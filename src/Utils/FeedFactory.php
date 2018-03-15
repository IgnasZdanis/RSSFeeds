<?php


namespace App\Utils;


use App\Entity\Feed;
use Symfony\Component\DomCrawler\Crawler;

class FeedFactory
{
    public function createFeedFromUrl(string $url, string $category) : Feed{
        $xml = file_get_contents($url);
        $crawler = new Crawler($xml);
        $title = $crawler->filterXPath('//rss/channel/title')->text();
        $articles = $crawler->filterXPath('//rss/channel/item');
        $articleCount = $crawler->filterXPath('//rss/channel/item')->count();
        $latestArticleTitle = null;
        $latestArticleUrl = null;
        if ($articleCount) {
            $maxDate = null;
            foreach ($articles as $article) {
                $crawler = new Crawler($article);
                if ($crawler->filterXPath('//pubDate')->count()) {
                    $articleDate = new \DateTime($crawler->filterXPath('//pubDate')->text());
                    if ($maxDate === null || $articleDate > $maxDate) {
                        $maxDate = $articleDate;
                        $latestArticleTitle = $crawler->filter('title')->text();
                        $latestArticleUrl = $crawler->filter('link')->text();
                    }
                }
                else {
                    $crawler = new Crawler($xml);
                    $latestArticleTitle = $crawler->filterXPath('//rss/channel/item[1]/title')->text();
                    $latestArticleUrl = $crawler->filterXPath('//rss/channel/item[1]/link')->text();
                    break;
                }
            }
        }
        return new Feed(
            $title,
            $url,
            $latestArticleTitle,
            $latestArticleUrl,
            $articleCount,
            new \DateTime(),
            $category
        );
    }
}