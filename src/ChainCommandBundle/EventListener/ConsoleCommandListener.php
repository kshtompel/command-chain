<?php

namespace ChainCommandBundle\EventListener;


use ChainCommandBundle\ChainCollection\ChainCommandArrayCollection;
use ChainCommandBundle\ChainCommandEvents;
use ChainCommandBundle\ChainCollection\ChainCommandItem;
use ChainCommandBundle\Event\ChainCommandChainsExecuteEvent;
use ChainCommandBundle\Event\ChainCommandExecutedEvent;
use ChainCommandBundle\Event\ChainCommandFinishEvent;
use ChainCommandBundle\Event\ChainCommandStartEvent;
use ChainCommandBundle\Registry\ChainCommandCollectionRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ConsoleCommandListener
 *
 * @package ChainCommandBundle\EventListener
 */
class ConsoleCommandListener
{
    /**
     * @var ChainCommandCollectionRegistry
     */
    private $chainRegistry;

    /**
     * ConsoleCommandListener constructor.
     *
     * @param ChainCommandCollectionRegistry $chainRegistry
     */
    public function __construct(ChainCommandCollectionRegistry $chainRegistry)
    {
        $this->chainRegistry = $chainRegistry;
    }

    /**
     * Listener method for console.command event.
     *
     * @param ConsoleCommandEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function onConsoleCommand(ConsoleCommandEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $command = $event->getCommand();
        $app = $command->getApplication();

        $chains = $this->chainRegistry->getByParent($command->getName());

        if ($chains->count()) {
            $input = $event->getInput();
            $output = $event->getOutput();
            $bufferedOutput = new BufferedOutput();

            $dispatchEvent = new ChainCommandStartEvent($command, $chains);
            $dispatcher->dispatch(ChainCommandEvents::CHAIN_START, $dispatchEvent);

            // Run parent command itself.
            $command->run($input, $bufferedOutput);
            $message = $this->writeCommandOutputToConsole($bufferedOutput, $output);

            $dispatchEvent = new ChainCommandExecutedEvent($command, $message);
            $dispatcher->dispatch(ChainCommandEvents::CHAIN_COMMAND_EXECUTED, $dispatchEvent);

            $dispatchEvent = new ChainCommandChainsExecuteEvent($command);
            $dispatcher->dispatch(ChainCommandEvents::CHAIN_COMMAND_CHAINS_EXECUTE, $dispatchEvent);

            foreach ($chains as $chain) {
                /** @var ChainCommandItem $chain */
                $chainCommand = $app->find($chain->getName());
                $chainCommand->run(new ArrayInput([]), $bufferedOutput);
                $message = $this->writeCommandOutputToConsole($bufferedOutput, $output);
                $dispatchEvent = new ChainCommandExecutedEvent($chainCommand, $message);
                $dispatcher->dispatch(ChainCommandEvents::CHAIN_COMMAND_EXECUTED, $dispatchEvent);
            }

            $dispatchEvent = new ChainCommandFinishEvent($command);
            $dispatcher->dispatch(ChainCommandEvents::CHAIN_FINISH, $dispatchEvent);

            $event->disableCommand();
        } else if ($item = $this->chainRegistry->get($command->getName())) {
            /** @var ChainCommandItem $item */

            $message = sprintf(
                'Error: %s <info>command</info> is a member of %s command chain and cannot be executed on its own.',
                $item->getName(),
                $item->getParent()
            );
            $event
                ->getOutput()
                ->getFormatter()
                ->getStyle('info')
                ->setForeground('cyan');
            $event
                ->getOutput()
                ->write([$message], true);

            $event->disableCommand();
        }
    }

    /**
     * Write buffered output to console and return it.
     *
     * @param BufferedOutput $buffer
     * @param OutputInterface $output
     *
     * @return string
     */
    private function writeCommandOutputToConsole(BufferedOutput $buffer, OutputInterface $output)
    {
        $result = $buffer->fetch();

        $output->write($result);

        return $result;
    }
}
