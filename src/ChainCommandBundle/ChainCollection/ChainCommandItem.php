<?php

namespace ChainCommandBundle\ChainCollection;


/**
 * Class ChainCommandItem
 *
 * It is used by ChainCommandCollectionInterface.
 * Store all necessary data about command.
 *
 * @package ChainCommandBundle\ChainCollection
 */
class ChainCommandItem
{
    /**
     * Command name.
     *
     * @var string
     */
    private $name;

    /**
     * Parent command name.
     *
     * @var string
     */
    private $parent;


    /**
     * ChainCommandItem constructor.
     *
     * @param $name
     * @param $parent
     */
    public function __construct($name, $parent)
    {
        if (!$parent) {
            throw new \RuntimeException(
                sprintf('$parent variable is required and shouldn\'t be empty for %s class', ChainCommandItem::class)
            );
        }

        if (!$name) {
            throw new \RuntimeException(
                sprintf('$name variable is required and shouldn\'t be empty for %s class', ChainCommandItem::class)
            );
        }

        $this->name = $name;
        $this->parent = $parent;
    }

    /**
     * Get command name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get command parent name.
     *
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }
}
