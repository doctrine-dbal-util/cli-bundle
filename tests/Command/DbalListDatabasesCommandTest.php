<?php




// TODO
// Try Define Commands as Services instead of ContainerAwareCommand or build a kernel with Symofny flex!
// Deprecate ContainerAwareCommand https://github.com/symfony/symfony/issues/21623
// How to Define Commands as Services https://symfony.com/doc/master/console/commands_as_services.html
// Read 3.4 and 4.x version




namespace Tests\Command;
// namespace DoctrineDbalUtil\CliBundle\Command;

use DoctrineDbalUtil\CliBundle\Command\DbalListDatabasesCommand; // ContainerAwareCommand: needs kernel! -No more!
// use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Application;
// use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use \PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

// class DbalListDatabasesCommandTest extends KernelTestCase
class DbalListDatabasesCommandTest extends TestCase
{
    public function testExecute()
    {
        // // self::bootKernel();
        // $kernel = static::createKernel();
        // // $application = new Application(self::$kernel);
        // $application = new Application(static::createKernel());
        $application = new Application();

        $application->add(new DbalListDatabasesCommand(\Doctrine\DBAL\DriverManager::getConnection(
            ['url' => 'sqlite:///:memory:',], 
            new \Doctrine\DBAL\Configuration()
        )));

        $command = $application->find('dbal:list-databases');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),

            // pass arguments to the helper
            //...'username' => 'Wouter',

            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        // $this->assertContains('Username: Wouter', $output);

        // ...
    }
}
