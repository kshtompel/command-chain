<?php

namespace ChainCommandBundle\ChainCollection;

/**
 * Class ChainCommandCollection
 *
 * Store all chained commands.
 *
 * @package ChainCommandBundle\ChainCollection
 */
class ChainCommandArrayCollection implements ChainCommandCollectionInterface, \Iterator
{
    /**
     * @var array|ChainCommandItem[]
     */
    private $commands = [];

    /**
     * Construct
     *
     * @param array|ChainCommandItem[] $commands
     */
    public function __construct(array $commands = [])
    {
        foreach ($commands as $command) {
            $this->addCommand($command);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addCommand(ChainCommandItem $command)
    {
        $this->commands[$command->getName()] = $command;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addCommands(ChainCommandCollectionInterface $commands)
    {
        foreach ($commands as $command) {
            $this->addCommand($command);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand($name)
    {
        if (isset($this->commands[$name])) {
            return $this->commands[$name];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCommand($name)
    {
        return isset($this->commands[$name]);
    }

    /**
     * {@inheritoc}
     */
    public function removeCommand($name)
    {
        unset ($this->commands[$name]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->commands);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return next($this->commands);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->commands);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return key($this->commands) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        return reset($this->commands);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->commands);
    }
}