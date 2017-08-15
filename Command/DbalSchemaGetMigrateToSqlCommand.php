<?php

namespace DoctrineDbalUtil\CliBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DbalSchemaGetMigrateToSqlCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('dbal:schema:getMigrateToSql')
            //^ name from http://symfony.com/doc/current/doctrine.html
            ->setDescription('Shows how actual DB schema differs from configured one.')
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

        // $conn = $this->getDBAL();
        $conn = $this->getContainer()->get('doctrine.dbal.default_connection');
        $schema = $this->getContainer()->get('kernel')->getDbalSchema();
        foreach (($conn
                ->getSchemaManager()
                ->createSchema()
                ->getMigrateToSql($schema, $conn->getDatabasePlatform())
                ) as $line) :
            $output->writeln($line);
        endforeach;
    }
}
