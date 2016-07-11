<?php


namespace ChainCommandBundle\DependencyInjection\CompilerPass;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ChainCommandCompilerPass
 *
 * @package ChainCommandBundle\DependencyInjection\CompilerPass
 */
class ChainCommandCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('chain.command') as $serviceId => $tags) {
            foreach ($tags as $tagInfo) {

                if (!isset($tagInfo['chain'])) {
                    throw new \RuntimeException(
                        'The tag option "chain" is required for chain command.'
                    );
                }

                /** @var Command $command */
                $command = $container->get($serviceId);
                /** @var Command $parent */
                $parent = $container->get($tagInfo['chain']);

                if (!($command instanceof Command)
                    || !($parent instanceof Command)
                ) {
                    throw new \RuntimeException(
                        sprintf('Command does not inherit of %s class', Command::class)
                    );
                }

                $container
                    ->getDefinition('chain_command.registry')
                    ->addMethodCall('addAsParameters', [ $command->getName(), $parent->getName() ]);
            }
        }
    }
}
