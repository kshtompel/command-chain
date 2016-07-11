<?php

namespace ChainCommandBundle\Event;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ChainCommandChainsExecuteEvent
 * 
 * Event for chain command execution.
 *
 * @package ChainCommandBundle\Event
 */
class ChainCommandChainsExecuteEvent extends Event
{
    /**
     * @var Command
     */
    private $parent;


    /**
     * ChainCommandEvent constructor.
     *
     * @param Command $parent
     */
    public function __construct(Command $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent.
     *
     * @return Command
     */
    public function getParent()
    {
        return $this->parent;
    }
}