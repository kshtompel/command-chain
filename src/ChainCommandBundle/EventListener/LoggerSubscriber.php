<?php

namespace ChainCommandBundle\EventListener;


use ChainCommandBundle\ChainCollection\ChainCommandItem;
use ChainCommandBundle\ChainCommandEvents;
use ChainCommandBundle\Event\ChainCommandChainsExecuteEvent;
use ChainCommandBundle\Event\ChainCommandErrorEvent;
use ChainCommandBundle\Event\ChainCommandFinishEvent;
use ChainCommandBundle\Event\ChainCommandMasterExecuteEvent;
use ChainCommandBundle\Event\ChainCommandStartEvent;
use ChainCommandBundle\Event\ChainCommandExecutedEvent;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class LoggerSubscriber
 *
 * Logger subscriber for chain command execution.
 *
 * @package ChainCommandBundle\EventListener
 */
class LoggerSubscriber implements EventSubscriberInterface
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Log data about commands that will be executed.
     *
     * @param ChainCommandStartEvent $event
     */
    public function chainCommandStart(ChainCommandStartEvent $event)
    {
        // Log start.
        $message = sprintf(
            '%s is a master command of a command chain that has registered member commands',
            $event->getCommand()->getName()
        );

        $this->logger->info($message);

        // Log chains.
        $chains = $event->getChains();

        /** @var ChainCommandItem $chain */
        foreach ($chains as $chain) {
            $message = sprintf(
                '%s registered as a member of foo:hello command chain',
                $chain->getName()
            );

            $this->logger->info($message);
        }

        // Log master execution start.
        $message = sprintf(
            'Executing %s command itself first:',
            $event->getCommand()->getName()
        );

        $this->logger->info($message);
    }

    /**
     * Log data about master command.
     *
     * @param ChainCommandMasterExecuteEvent $event
     */
    public function chainCommandChainsExecute(ChainCommandChainsExecuteEvent $event)
    {
        $message = sprintf(
            'Executing %s chain members:',
            $event->getParent()->getName()
        );

        $this->logger->info($message);
    }

    /**
     * Log output of executed command.
     *
     * @param ChainCommandExecutedEvent $event
     */
    public function chainCommandExecuted(ChainCommandExecutedEvent $event)
    {
        $message = sprintf('%s', $event->getOutput());

        $this->logger->info($message);
    }

    /**
     * Log data about chain command execution finished.
     *
     * @param ChainCommandFinishEvent $event
     */
    public function chainCommandFinish(ChainCommandFinishEvent $event)
    {
        $message = sprintf('Execution of %s chain completed.', $event->getCommand()->getName());

        $this->logger->info($message);
    }

    /**
     * Log error while execution chain member.
     *
     * @param ChainCommandErrorEvent $event
     */
    public function chainCommandError(ChainCommandErrorEvent $event)
    {
        $message = sprintf(
            '%s command is a member of %s command chain and cannot be executed on its own.',
            $event->getCommand()->getName(),
            $event->getParent()->getName()
        );

        $this->logger->error($message);
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ChainCommandEvents::CHAIN_START => 'chainCommandStart',
            ChainCommandEvents::CHAIN_COMMAND_CHAINS_EXECUTE => 'chainCommandChainsExecute',
            ChainCommandEvents::CHAIN_COMMAND_EXECUTED => 'chainCommandExecuted',
            ChainCommandEvents::CHAIN_FINISH => 'chainCommandFinish',
            ChainCommandEvents::CHAIN_COMMAND_ERROR => 'chainCommandError',
        ];
    }
}
