<?php

namespace Tests\Command;
// namespace DoctrineDbalUtil\CliBundle\Command;

use DoctrineDbalUtil\CliBundle\Command\DbalListDatabasesCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DbalListDatabasesCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new DbalListDatabasesCommand());

        $command = $application->find('dbal:list-databases');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),

            // pass arguments to the helper
            //...'username' => 'Wouter',

            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ));

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        // $this->assertContains('Username: Wouter', $output);

        // ...
    }
}
