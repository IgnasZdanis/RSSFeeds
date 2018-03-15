<?php


namespace App\Utils;


use App\Entity\Feed;

class FeedFactory
{

    private $rssParser;

    public function __construct(RssParser $rssParser)
    {
        $this->rssParser = $rssParser;
    }

    public function createFeedFromUrl(string $url, string $category) : Feed{
        if(!$xml = @file_get_contents($url)) {
            throw new \InvalidArgumentException('Url is not valid or could not get its content', 2);
        }
        $info = $this->rssParser->getRssInfo($xml);

        return new Feed(
            $info['title'],
            $url,
            $info['latestArticleTitle'],
            $info['latestArticleUrl'],
            $info['articleCount'],
            new \DateTime(),
            $category
        );
    }
}