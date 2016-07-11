<?php


namespace ChainCommandBundle\ChainCollection;

/**
 * Interface ChainCommandCollectionInterface
 *
 * @package ChainCommandBundle\ChainCollection
 */
interface ChainCommandCollectionInterface extends \Countable
{
    /**
     * Add command to collection
     *
     * @param ChainCommandItem $action
     */
    public function addCommand(ChainCommandItem $action);

    /**
     * Add commands
     *
     * @param ChainCommandCollectionInterface $actions
     */
    public function addCommands(ChainCommandCollectionInterface $actions);

    /**
     * Get command from collection
     *
     * @param string $name
     *
     * @return ChainCommandItem|null
     */
    public function getCommand($name);

    /**
     * Has command
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasCommand($name);

    /**
     * Remove command from collection.
     *
     * @param string $name
     */
    public function removeCommand($name);
}