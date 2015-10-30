<?php

namespace Marmelab\Dobble;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
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

        $this->addOption(
            'mini',
            null,
            InputOption::VALUE_NONE,
            'If specified, fetch the minimum card for given elements per card'
        );

        $this->addOption(
            'hide-cards',
            'c',
            InputOption::VALUE_NONE,
            'Hide cards for better lisibility'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nbElements = $input->getArgument('elements_per_card');
        $mini = $input->getOption('mini');

        if ($nbElements <= 1) {
            $output->writeln('<error>Number of elements must be a positive integer and greater than one</error>');

            return 1;
        }

        try {
            $mode = ($mini) ? DeckGenerator::ALGO_MINI : DeckGenerator::ALGO_DEFAULT;
            $generator = new DeckGenerator($nbElements, $mode);
            $deck = $generator->generate();
        } catch (DobbleException $e) {
            if (!$mini) {
                $output->writeln('<comment>Unable to generate with default mode. Trying now with --mini mode</comment>');
                $generator = new DeckGenerator($nbElements, DeckGenerator::ALGO_MINI);
                $deck = $generator->generate();
            } else {
                $output->writeln(sprintf('Error: <error>%s</error>', $e->getMessage()));

                return 1;
            }
        }

        $output->writeln(sprintf('Elements per card: <info>%d</info>', $nbElements));
        $output->writeln(sprintf('Deck generated with <info>%d</info> cards', count($deck)));
        if (!$input->getOption('hide-cards')) {
            $output->writeln('Cards :');
            foreach ($deck->getCards() as $card) {
                $output->writeln(sprintf('- %s', $card));
            }
        }
        if ($deck->validate()) {
            $output->writeln('Deck is valid: <info>true</info>');
        }
    }
}
