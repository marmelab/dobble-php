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
        $nb_elements = $input->getArgument('elements_per_card');

        if ($nb_elements <= 0) {
            $output->writeln('<error>Number of elements must be a postive integer</error>');

            return 1;
        }

        $output->writeln(sprintf('Elements per card <info>%d</info>', $nb_elements));
    }
}
