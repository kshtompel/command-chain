<?php

namespace Tests\ChainCommandBundle\EventListener;

use AppKernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class ConsoleCommandListenerTest extends WebTestCase
{
    private $app;

    protected function setUp()
    {
        $kernel = new AppKernel('test', true);

        $this->app = new Application($kernel);

        $this->app->setAutoExit(false);
    }

    protected function tearDown()
    {
        unset($this->app);
        parent::tearDown();
    }

    /**
     * Test master command chain run.
     */
    public function testMasterChainCommand()
    {

        $input = new ArrayInput(['foo:hello']);
        $output = new BufferedOutput();

        $this->app->run($input, $output);

        $this->assertStringMatchesFormat("Hello from Foo!\n%s\n%s", $output->fetch());
    }

    /**
     * Test members commands chain run..
     *
     * @dataProvider getMemberChainCommands
     *
     * @param $commands
     */
    public function testMemberChainCommand($commands)
    {
        foreach ($commands as $name) {
            $input = new ArrayInput([$name]);
            $output = new BufferedOutput();

            $this->app->run($input, $output);

            $this->assertStringStartsWith(sprintf('Error: %s command is a member', $name), $output->fetch());
        }
    }
    
    public function getMemberChainCommands()
    {
        return [
            [
                [
                    'baz:hey',
                    'baz:yo'
                ]
            ]
        ];
    }
}