<?php

namespace ChainCommandBundle\Event;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ChainCommandFinishEvent
 *
 * Main chain command event
 *
 * @package ChainCommandBundle\Event
 */
class ChainCommandFinishEvent extends Event
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
