<?php

namespace Tests\ChainCommandBundle\EventListener;

use ChainCommandBundle\ChainCollection\ChainCommandArrayCollection;
use ChainCommandBundle\ChainCollection\ChainCommandItem;
use ChainCommandBundle\EventListener\ConsoleCommandListener;
use ChainCommandBundle\Registry\ChainCommandCollectionRegistry;
use Symfony\Component\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Tests\ChainCommandBundle\Command\BazHeyTestCommand;
use Tests\ChainCommandBundle\Command\BazYoTestCommand;
use Tests\ChainCommandBundle\Command\FooTestCommand;


class ConsoleCommandListenerTest extends WebTestCase
{
    /**
     * @var Application
     */
    private $app;

    protected function setUp()
    {
        $this->app = new Application();
        // Test commands
        $this->app->add(new FooTestCommand());
        $this->app->add(new BazHeyTestCommand());
        $this->app->add(new BazYoTestCommand());

        $registry = $this->getRegistryOfChainCommands();
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

    public function testChainCommandItem()
    {
        $name = 'commandName';
        $parent = 'parentCommand';
        $chainCommand = new ChainCommandItem($name, $parent);
        $this->assertEquals($name, $chainCommand->getName());
        $this->assertEquals($parent, $chainCommand->getParent());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testChainCommandItemEmptyNameException()
    {
        $chainCommand = new ChainCommandItem('', 'someName');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testChainCommandItemEmptyParentException()
    {
        $chainCommand = new ChainCommandItem('someName', '');
    }

    /**
     * @depends testChainCommandItem
     *
     * @expectedException PHPUnit_Framework_Error
     */
    public function testChainCommandCollectionTypeHintError()
    {
        $collection = new ChainCommandArrayCollection();
        $chainItem = new \stdClass();

        $collection->addCommand($chainItem);
    }

    /**
     * @depends testChainCommandCollectionTypeHintError
     */
    public function testChainCommandCollectionNotEmpty()
    {
        $collection = new ChainCommandArrayCollection();

        $chainItem = new ChainCommandItem('name', 'parent');
        $collection->addCommand($chainItem);

        $this->assertCount(1, $collection);
    }

    /**
     * @depends testChainCommandCollectionTypeHintError
     */
    public function testChainCommandCollectionEmpty()
    {
        $collection = new ChainCommandArrayCollection();

        $chainItem = new ChainCommandItem('name', 'parent');
        $collection->addCommand($chainItem);

        $collection->removeCommand($chainItem);

        $this->assertCount(0, $collection);
    }

    /**
     * @depends testChainCommandCollectionTypeHintError
     */
    public function testChainCommandCollectionContains()
    {
        $collection = new ChainCommandArrayCollection();

        $chainItem = new ChainCommandItem('name', 'parent');
        $collection->addCommand($chainItem);

        $this->assertTrue($collection->hasCommand($chainItem));
        $this->assertTrue($collection->has($chainItem->getName()));
    }

    /**
     * @depends testChainCommandCollectionNotEmpty
     * @depends testChainCommandCollectionContains
     */
    public function testChainCommandRegistry()
    {
        $chainItem = new ChainCommandItem(BazHeyTestCommand::NAME , FooTestCommand::NAME);

        $registry = $this->getRegistryOfChainCommands();


        $this->assertEquals($registry->get(BazHeyTestCommand::NAME), $chainItem);

        $this->assertCount(2, $registry->getByParent(FooTestCommand::NAME));
    }

    /**
     * @depends testChainCommandRegistry
     */
    public function testMasterChainCommand()
    {
        $tester = new ApplicationTester($this->app);
        $tester->run(['command' => FooTestCommand::NAME]);

        $this->assertStringMatchesFormat(FooTestCommand::MESSAGE."\n%s\n%s", $tester->getDisplay());
    }

    /**
     * @dataProvider getMemberChainCommands
     *
     * @depends testChainCommandRegistry
     */
    public function testMemberChainCommand($commands)
    {
        foreach ($commands as $name => $parent) {
            $tester = new ApplicationTester($this->app);
            $tester->run(['command' => $name]);

            $this->assertStringStartsWith(
                sprintf(
                    'Error: %s command is a member of %s command chain and cannot be executed on its own.',
                    $name,
                    $parent
                ),
                $tester->getDisplay()
            );
        }
    }

    public function getMemberChainCommands()
    {
        return [
            [
                [
                    BazHeyTestCommand::NAME => FooTestCommand::NAME,
                    BazYoTestCommand::NAME  => FooTestCommand::NAME,
                ],
            ],
        ];
    }

    public function getRegistryOfChainCommands()
    {
        $commands = [
            BazHeyTestCommand::NAME => FooTestCommand::NAME,
            BazYoTestCommand::NAME  => FooTestCommand::NAME,
        ];

        $registry = new ChainCommandCollectionRegistry();

        foreach ($commands as $name => $parent) {
            $registry->addAsParameters($name, $parent);
        }

        return $registry;
    }
}