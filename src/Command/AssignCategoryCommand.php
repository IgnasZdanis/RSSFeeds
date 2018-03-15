<?php

namespace App\Command;

use App\Repository\FeedRepository;
use App\Utils\FeedFactory;
use App\Utils\FeedUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AssignCategoryCommand extends Command
{
    protected static $defaultName = 'assign-category';
    private $entityManager;
    private $feedFactory;
    private $feedRepository;
    private $feedUpdater;

    public function __construct(
        EntityManagerInterface $em,
        FeedFactory $feedFactory,
        FeedRepository $feedRepository,
        FeedUpdater $feedUpdater
    )
    {
        parent::__construct();

        $this->entityManager = $em;
        $this->feedFactory = $feedFactory;
        $this->feedRepository = $feedRepository;
        $this->feedUpdater = $feedUpdater;
    }

    protected function configure()
    {
        $this
            ->setDescription('Assign category to a RSS feed or update existing one')
            ->addArgument('url', InputArgument::REQUIRED, 'Url of the RSS feed (e. g. https://www.nfq.lt/rss)')
            ->addArgument(
                'category',
                InputArgument::OPTIONAL,
                'Category you want to assign to the feed.
                 If you do not pass this argument feed will be updated in every category it is assigned to.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');
        $category = $input->getArgument('category');
        if (!$category) {
            $feeds = $this->feedRepository->findByUrl($url);
            if (count($feeds)) {
                $this->feedUpdater->updateMany($feeds);
                $this->entityManager->flush();
                $io->success('Feed updated in ' . count($feeds) . ' categories');
            }
            else {
                $io->error('This url is not assigned to any category');
            }
        }
        else {
            $feed = $this->feedRepository->findByUrlAndCategory($url, $category);
            if ($feed) {
                $this->feedUpdater->updateOne(array_pop($feed));
                $this->entityManager->flush();
                $io->success('Feed updated in this category');
            }
            else {
                try {
                    $feed = $this->feedFactory->createFeedFromUrl($url, $category);
                    $this->entityManager->persist($feed);
                    $this->entityManager->flush();
                    $io->success('Category successfully assigned');
                }
                catch (\Exception $exception) {
                    $io->error($exception->getMessage());
                }
            }
        }
    }
}
