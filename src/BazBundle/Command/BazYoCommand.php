<?php


namespace BazBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BazYoCommand
 *
 * @package BazBundle\Command
 */
class BazYoCommand extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('baz:yo')
            ->setDescription('Yo Baz');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Yo Baz!';

        $output->writeln($text);
    }
}