<?php

namespace ChainCommandBundle;

use ChainCommandBundle\DependencyInjection\ChainCommandExtension;
use ChainCommandBundle\DependencyInjection\CompilerPass\ChainCommandCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ChainCommandBundle
 *
 * @package ChainCommandBundle
 */
class ChainCommandBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ChainCommandCompilerPass($this->getContainerExtension()));
    }

    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        if (!$this->extension) {
            $this->extension = new ChainCommandExtension();
        }

        return $this->extension;
    }
}
