<?php


namespace BazBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BazHeyCommand
 *
 * @package BazBundle\Command
 */
class BazHeyCommand extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('baz:hey')
            ->setDescription('Hey from Baz');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Hey from Baz!';

        $output->writeln($text);
    }
}