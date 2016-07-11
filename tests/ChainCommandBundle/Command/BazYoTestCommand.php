<?php


namespace Tests\ChainCommandBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BazYoTestCommand extends Command
{

    /**
     * Command name.
     */
    const NAME = 'baz:yo';

    /**
     * @var string
     */
    const MESSAGE = 'Yo Baz!';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Yo Baz');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(self::MESSAGE);
    }
}