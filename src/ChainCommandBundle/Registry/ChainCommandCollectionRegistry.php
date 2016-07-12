<?php

namespace ChainCommandBundle\Registry;

use ChainCommandBundle\ChainCollection\ChainCommandArrayCollection;
use ChainCommandBundle\ChainCollection\ChainCommandCollectionInterface;
use ChainCommandBundle\ChainCollection\ChainCommandItem;

/**
 * Class ChainCommandCollectionRegistry
 *
 * Class to store all chain commands
 *
 * @package ChainCommandBundle\Registry
 */
class ChainCommandCollectionRegistry implements ChainCommandRegistryInterface
{
    /**
     * @var ChainCommandCollectionInterface
     */
    private $commands;

    /**
     * ChainCommandCollectionRegistry constructor.
     */
    public function __construct()
    {
        $this->commands = new ChainCommandArrayCollection();
    }

    /**
     * Get commands collection by key.
     *
     * @param $key
     *
     * @return ChainCommandItem|null
     */
    public function get($key)
    {
        if ($this->commands->has($key)) {
            return $this->commands->getCommand($key);
        }

        return null;
    }

    /**
     * Get all.
     *
     * @param int|string $name
     *
     * @return ChainCommandCollectionInterface
     */
    public function getByParent($name)
    {
        $collection = new ChainCommandArrayCollection();
        /** @var ChainCommandItem $item */
        foreach ($this->commands as $item) {
            if ($name == $item->getParent()) {
                $collection->addCommand($item);
            }
        }

        return $collection;
    }

    /**
     * Build command and add command to the storage.
     *
     * @param $name
     * @param $parent
     */
    public function addAsParameters($name, $parent)
    {
        $item = new ChainCommandItem($name, $parent);
        $this->commands->addCommand($item);
    }
}