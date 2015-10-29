<?php

namespace Marmelab\Dobble;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class DobbleCommand extends Command
{
    protected function configure()
    {
        $this->setName('dobble:run');
        $this->setDescription('Command-line card generator for dobble-like game');

        $this->addArgument(
            'elements_per_card',
            InputArgument::REQUIRED,
            'Number of elements per card'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nbElements = $input->getArgument('elements_per_card');

        if ($nbElements <= 0) {
            $output->writeln('<error>Number of elements must be a positive integer</error>');

            return 1;
        }

        try {
            $generator = new DeckGenerator($nbElements);
            $deck = $generator->generate();
        } catch (DobbleException $e) {
            $output->writeln(sprintf('Error: <error>%s</error>', $e->getMessage()));

            return 1;
        }

        $output->writeln(sprintf('Elements per card: <info>%d</info>', $nbElements));
        $output->writeln(sprintf('Deck generated with <info>%d</info> cards', count($deck)));
        $output->writeln('Cards :');
        foreach ($deck->getCards() as $card) {
            $output->writeln(sprintf('- %s', $card));
        }
        if ($deck->validate()) {
            $output->writeln('Deck is valid: <info>true</info>');
        }
    }
}
