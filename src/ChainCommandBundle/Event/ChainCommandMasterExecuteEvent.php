<?php

namespace ChainCommandBundle\Event;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ChainCommandMasterExecuteEvent
 * 
 * Event for chain command execution.
 *
 * @package ChainCommandBundle\Event
 */
class ChainCommandMasterExecuteEvent extends Event
{
    /**
     * @var Command
     */
    private $command;


    /**
     * ChainCommandEvent constructor.
     *
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
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
}
