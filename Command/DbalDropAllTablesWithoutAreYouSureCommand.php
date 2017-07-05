<?php

namespace DbalUtil\CliBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DbalDropAllTablesWithoutAreYouSureCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('dbal:drop-all-tables-without-are-you-sure')
            ->setDescription('Drop All Default Connection Database\'s Tables with(out) CASCADE.')
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

        $conn = $this->getContainer()->get('doctrine.dbal.default_connection');
        foreach ($conn
                ->getSchemaManager()
                ->listTables()
                as $table):
            $output->writeln($table->getName());
            $conn->exec('DROP TABLE "' . $table->getName() . '" CASCADE'); // "" for reserved keyword like in: DROP TABLE "user"
        endforeach;
    }

}
