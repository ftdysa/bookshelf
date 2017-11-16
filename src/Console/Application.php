<?php

namespace Bookshelf\Console;

use Bookshelf\Application as AppKernel;
use Bookshelf\Console\Command\GenerateEntitiesCommand;
use Bookshelf\Console\Command\RunFixturesCommand;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Helper\QuestionHelper;

class Application extends BaseApplication {
    /**
     * @var \Bookshelf\Application
     */
    private $app;

    public function __construct(AppKernel $app) {
        $this->app = $app;
        $this->registerHelpers();
        $this->registerCommands();

        parent::__construct('Bookshelf CLI', '0.1.0');
    }

    /**
     * @return AppKernel
     */
    public function getAppKernel() {
        return $this->app;
    }

    private function registerHelpers() {
        $em = $this->app['doctrine.orm.entity_manager'];
        $this->setHelperSet(ConsoleRunner::createHelperSet($em));
        $this->getHelperSet()->set(new QuestionHelper());
    }

    private function registerCommands() {
        $this->addCommands([
            // Bookshelf commands
            new GenerateEntitiesCommand(),
            new RunFixturesCommand(),

            // ORM Commands
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
            new \Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
            new \Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand(),
            new \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
            new \Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand(),
            new \Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),
            new \Doctrine\ORM\Tools\Console\Command\InfoCommand(),

            // Migrations Commands
            new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand(),
            new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand(),
            new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand(),
            new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand(),
            new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand(),
            new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand()
        ]);
    }
}