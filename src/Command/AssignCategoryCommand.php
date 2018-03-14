<?php

namespace App\Command;

use App\Utils\FeedFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\UrlValidator;

class AssignCategoryCommand extends Command
{
    protected static $defaultName = 'assign-category';
    private $entityManager;
    private $feedFactory;

    /**
     */
    public function __construct(EntityManagerInterface $em, FeedFactory $feedFactory)
    {
        parent::__construct();

        $this->entityManager = $em;
        $this->feedFactory = $feedFactory;
    }


    protected function configure()
    {
        $this
            ->setDescription('Assign category to a RSS feed')
            ->addArgument('url', InputArgument::REQUIRED, 'Url of the RSS feed')
            ->addArgument(
                'category',
                InputArgument::REQUIRED,
                'Category you want to assign to the feed')
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');
        $category = $input->getArgument('category');
        $feed = $this->feedFactory->createFeedFromUrl($url, $category);
        $this->entityManager->persist($feed);
        $this->entityManager->flush();
        $io->success('Category successfully assigned');
    }
}
