<?php

namespace App\Controller;

use App\Repository\FeedRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FeedController extends Controller
{
    /**
     * @Route("/feed/{category}", name="feed")
     */
    public function index(string $category, FeedRepository $feedRepository)
    {
        $feeds = $feedRepository->findByCategory($category);
        return $this->render('feed/index.html.twig', [
            'feeds' => $feeds,
        ]);
    }
}
