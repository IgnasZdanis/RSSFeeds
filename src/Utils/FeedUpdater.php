<?php


namespace App\Utils;


use App\Entity\Feed;

class FeedUpdater
{
    private $rssParser;
    public function __construct(RssParser $rssParser)
    {
        $this->rssParser = $rssParser;
    }

    public function updateOne(Feed $feed) : Feed{
        $url = $feed->getUrl();
        $xml = file_get_contents($url);
        $info = $this->rssParser->getRssInfo($xml);

        return $this->updateInformation($feed, $info);
    }

    public function updateMany(array $feeds) : array {
        $url = array_pop($feeds)->getUrl();
        $xml = file_get_contents($url);
        $info = $this->rssParser->getRssInfo($xml);
        foreach($feeds as $feed) {
            $feed = $this->updateInformation($feed, $info);
        }

        return $feeds;
    }

    private function updateInformation(Feed $feed, array $info) : Feed{
        $feed->setTitle($info['title']);
        $feed->setArticleCount($info['articleCount']);
        $feed->setMostRecentArticleTitle($info['latestArticleTitle']);
        $feed->setMostRecentArticleUrl($info['latestArticleUrl']);
        $feed->setUpdateDate(new \DateTime());

        return $feed;
    }
}