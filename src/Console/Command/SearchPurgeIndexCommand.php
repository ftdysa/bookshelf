<?php

declare(strict_types=1);

namespace Bookshelf\Console\Command;

use Bookshelf\Search\IndexManager;
use Bookshelf\Search\Searchable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SearchPurgeIndexCommand extends Command {
    private $manager;
    private $em;

    public function __construct(IndexManager $manager, EntityManagerInterface $em) {
        $this->manager = $manager;
        $this->em = $em;

        parent::__construct();
    }

    protected function configure() {
        $this
            ->setName('bookshelf:search-purge')
            ->setDescription('This is a command to help with purging the Algolia search index.')
            ->addOption('index', 'i', InputOption::VALUE_OPTIONAL, 'Purge a specific index.')
            ->addOption('id', null, InputOption::VALUE_OPTIONAL, 'Purge a specific object (must use with --index)');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $searchableObjs = $this->manager->getSearchableEntities();
        $index = $input->getOption('index');
        $id = $input->getOption('id');

        if ($index) {
            $searchableObjs = array_filter($searchableObjs, function ($className) use ($index) {
                $obj = new $className();

                return $obj instanceof Searchable && $obj->getIndexName() === $index;
            });
        }

        foreach ($searchableObjs as $obj) {
            $repo = $this->em->getRepository($obj);

            if ($id && $index) {
                $objects = [$repo->find($id)];
            } else {
                // TODO: paginate or move to a cursor based approach.
                $objects = $repo->findAll();
            }

            $count = count($objects);
            $output->writeln("<info>Removing $count $obj object(s) ...</info>");

            $this->manager->remove($objects);
        }
    }
}
