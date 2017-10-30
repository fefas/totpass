<?php

namespace Fefas\TotPass\Infrastructure\Commands;

use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Fefas\TotPass\TotPassword\Model\TotPasswordRepository;

class RevealCommand extends Command
{
    private const DEFAULT_OPTION_DATE_TIME = null;

    private $totPasswordRepository;

    public function __construct(TotPasswordRepository $totPasswordRepository)
    {
        $this->totPasswordRepository = $totPasswordRepository;

        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('reveal')
            ->setDescription('Reveal registered time-based one-time passwords')
            ->setHelp('This command allows you to list and filter the registered time-based one-time passwords.');

        $this
            ->addOption(
                'date-time',
                null,
                InputOption::VALUE_REQUIRED,
                'Considered date time to generate TOT Passwords',
                self::DEFAULT_OPTION_DATE_TIME
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $totPasswords = $this->totPasswordRepository->findAll();

        if (0 === count($totPasswords)) {
            $output->writeln('<comment>Nothing to show..</comment>');
            return;
        }

        $dateTime = new DateTime($input->getOption('date-time'));
        $dateTimeFormatted = $dateTime->format('Y-m-d H:i:s');
        $output->writeln("<comment>Considered date time: $dateTimeFormatted</comment>");

        $outputTableRows = [];
        foreach ($totPasswords as $totPassword) {
            $outputTableRows[] = [
                $totPassword->name(),
                $totPassword->retrieveAt($dateTime),
            ];
        }

        $outputTable = new Table($output);
        $outputTable
            ->setStyle('compact')
            ->setRows($outputTableRows)
            ->render();
    }
}
