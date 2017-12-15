<?php

declare(strict_types=1);

namespace Bookshelf\Console\Command;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\EntityGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateEntitiesCommand extends Command {
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure() {
        $this
            ->setName('bookshelf:generate-entities')
            ->setDescription('Generate doctrine entities from the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $root_dir = __DIR__.'/../../../';

        // fetch metadata
        $driver = new \Doctrine\ORM\Mapping\Driver\DatabaseDriver(
            $this->em->getConnection()->getSchemaManager()
        );
        $driver->setNamespace('Entity\\');
        $this->em->getConfiguration()->setMetadataDriverImpl($driver);
        $cmf = new \Doctrine\ORM\Tools\DisconnectedClassMetadataFactory();
        $cmf->setEntityManager($this->em);
        $metadata = $cmf->getAllMetadata();
        $generator = new EntityGenerator();
        $generator->setUpdateEntityIfExists(true);
        $generator->setGenerateStubMethods(true);
        $generator->setGenerateAnnotations(true);
        $generator->generate($metadata, $root_dir.'/src');

        // fix namespaces since doctrine's generator doesn't like psr-4
        $search = [
            '\\Entity\\',
            'namespace Entity;',
            '"Entity\\',
        ];

        $replace = [
            '',
            'namespace Bookshelf\\Entity;',
            '"Bookshelf\\Entity\\',
        ];

        foreach (scandir('src/Entity') as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $full_path = $root_dir.'/src/Entity/'.$file;

            $contents = file_get_contents($full_path);
            $contents = str_replace($search, $replace, $contents);
            file_put_contents($full_path, $contents);
        }

        $output->writeln('<info>Entities successfully generated.</info>');
    }
}
