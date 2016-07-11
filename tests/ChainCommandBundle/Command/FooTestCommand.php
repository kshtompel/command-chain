<?php


namespace Tests\ChainCommandBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class FooTestCommand extends Command
{
    /**
     * Command name.
     */
    const NAME = 'foo:hello';

    /**
     * @var string
     */
    const MESSAGE = 'Hello from Foo!';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Hello from Foo');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(self::MESSAGE);
    }
}