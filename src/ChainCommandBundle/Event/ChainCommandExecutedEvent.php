<?php

namespace ChainCommandBundle\Event;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ChainCommandExecutedEvent
 * 
 * Event for chain command execution.
 *
 * @package ChainCommandBundle\Event
 */
class ChainCommandExecutedEvent extends Event
{
    /**
     * @var Command
     */
    private $command;

    /**
     * @var string
     */
    private $output;

    /**
     * ChainCommandEvent constructor.
     *
     * @param Command $command
     * @param string $output
     */
    public function __construct(Command $command, $output)
    {
        $this->command = $command;
        $this->output = $output;
    }

    /**
     * @return Command
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }
}