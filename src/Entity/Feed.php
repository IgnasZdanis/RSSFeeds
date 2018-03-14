<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeedRepository")
 */
class Feed
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $category;
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Url()
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mostRecentArticleTitle;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mostRecentArticleUrl;

    /**
     * @ORM\Column(type="integer")
     */
    private $articleCount;

    /**
     * @param $title
     * @param $url
     * @param $mostRecentArticleTitle
     * @param $mostRecentArticleUrl
     * @param $articleCount
     * @param $updateDate
     */
    public function __construct($title, $url, $mostRecentArticleTitle, $mostRecentArticleUrl, $articleCount, $updateDate, $category)
    {
        $this->title = $title;
        $this->url = $url;
        $this->mostRecentArticleTitle = $mostRecentArticleTitle;
        $this->mostRecentArticleUrl = $mostRecentArticleUrl;
        $this->articleCount = $articleCount;
        $this->updateDate = $updateDate;
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getMostRecentArticleTitle()
    {
        return $this->mostRecentArticleTitle;
    }

    /**
     * @param mixed $mostRecentArticleTitle
     */
    public function setMostRecentArticleTitle($mostRecentArticleTitle): void
    {
        $this->mostRecentArticleTitle = $mostRecentArticleTitle;
    }

    /**
     * @return mixed
     */
    public function getMostRecentArticleUrl()
    {
        return $this->mostRecentArticleUrl;
    }

    /**
     * @param mixed $mostRecentArticleUrl
     */
    public function setMostRecentArticleUrl($mostRecentArticleUrl): void
    {
        $this->mostRecentArticleUrl = $mostRecentArticleUrl;
    }

    /**
     * @return mixed
     */
    public function getArticleCount()
    {
        return $this->articleCount;
    }

    /**
     * @param mixed $articleCount
     */
    public function setArticleCount($articleCount): void
    {
        $this->articleCount = $articleCount;
    }

    /**
     * @return mixed
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param mixed $updateDate
     */
    public function setUpdateDate($updateDate): void
    {
        $this->updateDate = $updateDate;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateDate;
}
