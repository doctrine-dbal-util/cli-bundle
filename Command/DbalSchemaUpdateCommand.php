<?php

namespace DbalUtil\CliBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DbalSchemaUpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('dbal:schema:update')
            //^ name from http://symfony.com/doc/current/doctrine.html
            ->setDescription('Put Schema in a preferably empty database.')
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
        $currentUser = get_current_user();
        $additionalSql__disabled = <<<"EOT"
-- ALTER TABLE ""user"" ALTER uuid SET DEFAULT gen_random_uuid();
-- ALTER TABLE owned_url ALTER uuid SET DEFAULT gen_random_uuid();
-- ALTER TABLE taxonomy_leaf ALTER uuid SET DEFAULT gen_random_uuid();
-- ALTER TABLE taxonomy_tree ALTER uuid SET DEFAULT gen_random_uuid();
-- ALTER TABLE link_owned_url_taxonomy ALTER uuid SET DEFAULT gen_random_uuid();
-- REVOKE UPDATE ON url FROM ""$currentUser""; -- also revokes right to modify foreign keys on other tables...
EOT;

        foreach ($schema->toSql($conn->getDatabasePlatform()) as $line) :
            $output->writeln($line);
            $conn->exec($line);
        endforeach;
        // $output->writeln($additional_sql);
        // $conn->exec($additional_sql);
        $output->writeln('Test if schema is in DB: almost nothing should appear below this line.');
        foreach (($conn
                ->getSchemaManager()
                ->createSchema()
                ->getMigrateToSql($schema, $conn->getDatabasePlatform())
                ) as $line) :
            $output->writeln($line);
        endforeach;
    }
}
