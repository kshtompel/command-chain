<?php

namespace ChainCommandBundle\Event;


use ChainCommandBundle\ChainCollection\ChainCommandCollectionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ChainCommandStartEvent
 *
 * Main chain command event
 *
 * @package ChainCommandBundle\Event
 */
class ChainCommandStartEvent extends Event
{
    /**
     * @var Command
     */
    private $command;

    /**
     * @var ChainCommandCollectionInterface
     */
    private $chains;

    /**
     * ChainCommandEvent constructor.
     *
     * @param Command $command
     * @param ChainCommandCollectionInterface $chains
     */
    public function __construct(Command $command, ChainCommandCollectionInterface $chains)
    {
        $this->command = $command;
        $this->chains = $chains;
    }

    /**
     * Get command.
     *
     * @return Command
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Get chains.
     *
     * @return array
     */
    public function getChains()
    {
        return $this->chains;
    }
}
