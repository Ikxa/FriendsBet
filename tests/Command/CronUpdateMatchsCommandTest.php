<?php


namespace App\Tests\Command;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CronUpdateMatchsCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        
        $command = $application->find('app:update-matchs');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                // pass arguments to the helper
                'username' => 'Jordan',
                
                // prefix the key with two dashes when passing options,
                // e.g: '--some-option' => 'option_value',
            ]
        );
        
        // the output of the command in the console
        $output = $commandTester->getDisplay();
        self::assertStringContainsString('Username: Jordan', $output);
    }
}
