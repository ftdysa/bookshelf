<?php

namespace Bookshelf\Console\Command;

use Doctrine\ORM\Tools\EntityGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateEntitiesCommand extends Command {

    protected function configure() {
        $this
            ->setName('bookshelf:generate-entities')
            ->setDescription('Generate doctrine entities from the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $root_dir = __DIR__.'/../../../';
        $em = $this->getApplication()->getAppKernel()['doctrine.orm.entity_manager'];

        // fetch metadata
        $driver = new \Doctrine\ORM\Mapping\Driver\DatabaseDriver(
            $em->getConnection()->getSchemaManager()
        );
        $driver->setNamespace('Entity\\');
        $em->getConfiguration()->setMetadataDriverImpl($driver);
        $cmf = new \Doctrine\ORM\Tools\DisconnectedClassMetadataFactory($em);
        $cmf->setEntityManager($em);
        $metadata = $cmf->getAllMetadata();
        $generator = new EntityGenerator();
        $generator->setUpdateEntityIfExists(true);
        $generator->setGenerateStubMethods(true);
        $generator->setGenerateAnnotations(true);
        $generator->generate($metadata, $root_dir.'/src');

        // fix namespaces since doctrine's generator doesn't like psr-4
        foreach (scandir('src/Entity') as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $full_path = $root_dir.'/src/Entity/'.$file;

            $contents = file_get_contents($full_path);
            $contents = str_replace('\\Entity\\', '', $contents);
            $contents = str_replace('namespace Entity;', 'namespace Bookshelf\\Entity;', $contents);
            file_put_contents($full_path, $contents);
        }

        $output->writeln('<info>Entities successfully generated.</info>');
    }
}