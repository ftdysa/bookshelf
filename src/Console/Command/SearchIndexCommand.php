<?php

namespace Bookshelf\Console\Command;

use Bookshelf\Search\IndexManager;
use Bookshelf\Search\Searchable;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SearchIndexCommand extends Command {
    private $manager;
    private $em;

    public function __construct(IndexManager $manager, ObjectManager $em) {
        $this->manager = $manager;
        $this->em = $em;

        parent::__construct();
    }

    protected function configure() {
        $this
            ->setName('bookshelf:search-index')
            ->setDescription('This is a command to help with managing the Algolia search index.')
            ->addOption('index', 'i', InputOption::VALUE_OPTIONAL, 'Index objects belonging to a specific index.')
            ->addOption('id', null, InputOption::VALUE_OPTIONAL, 'Index a specific object (must use with --index)');

    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $searchableObjs = $this->manager->getSearchableEntities();
        $index = $input->getOption('index');
        $id = $input->getOption('id');

        if ($index) {
            $searchableObjs = array_filter($searchableObjs, function($className) use ($index) {
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
            $output->writeln("<info>Indexing $count $obj object(s) ...</info>");

            $this->manager->index($objects);
        }
    }
}
