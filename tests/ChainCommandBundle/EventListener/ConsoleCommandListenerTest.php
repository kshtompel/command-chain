<?php

namespace Tests\ChainCommandBundle\EventListener;

use ChainCommandBundle\EventListener\ConsoleCommandListener;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Tests\ChainCommandBundle\Command\BazHeyTestCommand;
use Tests\ChainCommandBundle\Command\BazYoTestCommand;
use Tests\ChainCommandBundle\Command\FooTestCommand;
use Tests\ChainCommandBundle\DependencyInjection\ChainCommandTestExtension;
use Tests\ChainCommandBundle\DependencyInjection\CompilerPass\ChainCommandCompilerTestPass;

class ConsoleCommandListenerTest extends WebTestCase
{
    private $app;

    protected function setUp()
    {
        $this->app = new Application(self::$kernel);
        // Test commands
        $this->app->add(new FooTestCommand());
        $this->app->add(new BazHeyTestCommand());
        $this->app->add(new BazYoTestCommand());

        $container = new ContainerBuilder();

        // Test extension
        $chainCommandExtensionTest = new ChainCommandTestExtension();
        $chainCommandExtensionTest->load([], $container);

        // Test Compiler pass
        $pass = new ChainCommandCompilerTestPass();
        $pass->process($container);

        $registry = $container->get('chain_command.registry');

        // Depended real event listener.
        $listener = new ConsoleCommandListener($registry);

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('console.command', [$listener, 'onConsoleCommand']);

        $this->app->setDispatcher($dispatcher);
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

        $input = new ArrayInput([FooTestCommand::NAME]);
        $output = new BufferedOutput();

        $this->app->run($input, $output);

        $this->assertStringMatchesFormat(FooTestCommand::MESSAGE."\n%s\n%s", $output->fetch());
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
                    BazHeyTestCommand::NAME,
                    BazYoTestCommand::NAME
                ]
            ]
        ];
    }
}