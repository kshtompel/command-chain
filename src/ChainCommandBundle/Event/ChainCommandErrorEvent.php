<?php

namespace ChainCommandBundle\Event;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ChainCommandErrorEvent
 *
 * Event for chain command error execution.
 *
 * @package ChainCommandBundle\Event
 */
class ChainCommandErrorEvent extends Event
{
    /**
     * @var Command
     */
    private $command;

    /**
     * @var Command
     */
    private $parent;

    /**
     * ChainCommandEvent constructor.
     *
     * @param Command $command
     * @param Command $parent
     */
    public function __construct(Command $command, Command $parent)
    {
        $this->command = $command;
        $this->parent = $parent;
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
     * @return Command
     */
    public function getParent()
    {
        return $this->parent;
    }
}