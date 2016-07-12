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
     * @param array|ChainCommandItem[] $actions
     */
    public function addCommands(array $actions);

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
    public function has($name);

    /**
     * Has command
     *
     * @param ChainCommandItem $command
     *
     * @return bool
     */
    public function hasCommand(ChainCommandItem $command);

    /**
     * Remove command from collection.
     *
     * @param ChainCommandItem $command
     */
    public function removeCommand(ChainCommandItem $command);
}