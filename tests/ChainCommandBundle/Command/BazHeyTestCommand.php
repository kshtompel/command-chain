<?php


namespace Tests\ChainCommandBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class BazHeyTestCommand extends Command
{
    /**
     * Command name
     */
    const NAME = 'baz:hey';

    /**
     * @var string
     */
    const MESSAGE = 'Hey from Baz!';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Hey from Baz');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(self::MESSAGE);
    }
}