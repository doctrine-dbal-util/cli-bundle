<?php

namespace DoctrineDbalUtil\CliBundle\Command;

use Doctrine\DBAL\Connection;
// use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
// use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
// use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DbalListDatabasesCommand extends Command
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

        // you *must* call the parent constructor
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('dbal:list-databases')
            ->setDescription('List Default Connection Databases.')
            // ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            // ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // $argument = $input->getArgument('argument');

        // if ($input->getOption('option')) {
            // ...
        // }

        $output->writeln(
            // $this
                // // ->getDBAL()
                // ->getContainer()
                // ->get('doctrine.dbal.default_connection')
            $this->connection
                ->getSchemaManager()
                ->listDatabases()
        ); // Tested OK with Postgres.
        // TODO: see how to output an array.
    }
}
