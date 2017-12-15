<?php

namespace Bookshelf\Console\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RunFixturesCommand extends Command {
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure() {
        $this
            ->setName('bookshelf:run-fixtures')
            ->setDescription('Run doctrine data fixtures to seed the database.')
            ->addOption('purge', 'p', InputOption::VALUE_OPTIONAL, 'Purge previous fixture data.', false);
    }

    public function execute(InputInterface $input, OutputInterface $output) {
        $fixtures_dir = __DIR__.'/../../../db/fixtures';
        $output->writeln("Loading fixtures found in $fixtures_dir.");

        $loader = new Loader();
        $loader->loadFromDirectory($fixtures_dir);

        $should_purge = $input->hasParameterOption('--purge');
        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->em, $purger);
        if ($should_purge) {
            $executor->execute($loader->getFixtures());
        } else {
            $executor->execute($loader->getFixtures(), true);
        }

        $output->writeln(sprintf('<info>%d fixtures loaded.</info>', count($loader->getFixtures())));
    }
}
