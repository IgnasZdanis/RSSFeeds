<?php


namespace App\Utils;

use Symfony\Component\DomCrawler\Crawler;

class RssParser
{
    public function getRssInfo(string $xml) : array
    {
        $info = [];
        $crawler = new Crawler($xml);
        if (!$crawler->filterXPath('//rss')->count()) {
            throw new \InvalidArgumentException('Url is not a rss feed (e. g. https://www.nfq.lt/rss)', 1);
        }
        $articleCount = $crawler->filterXPath('//rss/channel/item')->count();
        $latestArticleInfo = $this->getLatestArticleInfo($articleCount, $xml);
        $info['title'] = $crawler->filterXPath('//rss/channel/title')->text();
        $info['articleCount'] = $crawler->filterXPath('//rss/channel/item')->count();
        $info['latestArticleTitle'] = $latestArticleInfo['title'];
        $info['latestArticleUrl'] = $latestArticleInfo['url'];

        return $info;
    }

    private function getLatestArticleInfo(int $articleCount, string $xml) : array
    {
        $crawler = new Crawler($xml);
        $info['title'] = null;
        $info['url'] = null;
        $articles = $crawler->filterXPath('//rss/channel/item');
        if ($articleCount) {
            $maxDate = null;
            foreach ($articles as $article) {
                $crawler = new Crawler($article);
                if ($crawler->filterXPath('//pubDate')->count()) {
                    $articleDate = new \DateTime($crawler->filterXPath('//pubDate')->text());
                    if ($maxDate === null || $articleDate > $maxDate) {
                        $maxDate = $articleDate;
                        $info['title'] = $crawler->filter('title')->text();
                        $info['url'] = $crawler->filter('link')->text();
                    }
                } else {
                    $crawler = new Crawler($xml);
                    $info['title'] = $crawler->filterXPath('//rss/channel/item[1]/title')->text();
                    $info['url'] = $crawler->filterXPath('//rss/channel/item[1]/link')->text();
                    break;
                }
            }
        }

        return $info;
    }
}
