<?php

namespace DbalUtil\CliBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DbalListDatabasesCommand extends ContainerAwareCommand
{
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
            $this
                // ->getDBAL()
                ->getContainer()
                ->get('doctrine.dbal.default_connection')
                ->getSchemaManager()
                ->listDatabases()
        ); // Tested OK with Postgres.
        // TODO: see how to output an array.
    }
}
