<?php

use Marmelab\Dobble\DobbleCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class DobbleCommandTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->app = new Application();
        $this->app->add(new DobbleCommand());

        $this->cmd = $this->app->find('dobble:run');
        $this->cmdTester = new CommandTester($this->cmd);
    }

    public function testCommandAcceptsPositiveInteger()
    {
        $elementsPerCard = rand();

        $this->cmdTester->execute([
            'command' => $this->cmd->getName(),
            'elements_per_card' => $elementsPerCard,
        ]);

        $this->assertRegExp(
            sprintf('/Elements per card: %d/', $elementsPerCard),
            $this->cmdTester->getDisplay()
        );
    }

    public function invalidValues()
    {
        return [
            'string' => ['NaN'],
            'null value' => [0],
            'negative value' => [-1],
        ];
    }

    /**
     * @dataProvider invalidValues
     */
    public function testCommandRefusesNonPositiveInteger($value)
    {
        $this->cmdTester->execute([
            'command' => $this->cmd->getName(),
            'elements_per_card' => $value,
        ]);

        $this->assertRegExp(
            '/must be a positive integer/',
            $this->cmdTester->getDisplay()
        );
    }
}
