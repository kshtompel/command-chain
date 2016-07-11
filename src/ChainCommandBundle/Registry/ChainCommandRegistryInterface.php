<?php

namespace ChainCommandBundle\Registry;

use ChainCommandBundle\ChainCollection\ChainCommandCollectionInterface;
use ChainCommandBundle\ChainCollection\ChainCommandItem;

/**
 * Interface ChainCommandRegistryInterface
 *
 * @package ChainCommandBundle\Registry
 */
interface ChainCommandRegistryInterface
{
    /**
     * Get command by key.
     *
     * @param integer|string $key
     *
     * @return mixed|null
     */
    public function get($key);

    /**
     * Get commands by parent key.
     *
     * @param integer|string $key
     *
     * @return mixed
     */
    public function getByParent($key);
}