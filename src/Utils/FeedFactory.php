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
        $update = $crawler->filterXPath('//rss/channel/lastBuildDate')->text();
        $latestArticleTitle = $crawler->filterXPath('//rss/channel/item[1]/title')->text();
        $latestArticleUrl = $crawler->filterXPath('//rss/channel/item[1]/link')->text();
        $articleCount = $crawler->filterXPath('//rss/channel/item')->count();
        $link = $crawler->filterXPath('//rss/channel/link')->text();
        return new Feed(
            $title,
            $link,
            $latestArticleTitle,
            $latestArticleUrl,
            $articleCount,
            new \DateTime($update),
            $category
        );
    }
}