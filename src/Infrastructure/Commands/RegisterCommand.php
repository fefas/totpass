<?php

namespace Fefas\TotPass\Infrastructure\Commands;

use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fefas\TotPass\TotPassword\Infrastructure\TotPasswordAlgorithm;
use Fefas\TotPass\TotPassword\Model\TotPassword;
use Fefas\TotPass\TotPassword\Model\TotPasswordRepository;

class RegisterCommand extends Command
{
    private $totPasswordRepository;

    public function __construct(TotPasswordRepository $totPasswordRepository)
    {
        $this->totPasswordRepository = $totPasswordRepository;

        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('register')
            ->setDescription('Register a new time-based one-time password')
            ->setHelp('This command allows you to register an new time-based one-time password.');

        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Name used to identify the register')
            ->addArgument('secret', InputArgument::REQUIRED, 'Secret to generate the TOTP');

        $this
            ->addOption(
                'refresh-period',
                null,
                InputOption::VALUE_OPTIONAL,
                'Password refresh period',
                30
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $totPasswordName = $input->getArgument('name');
        $totPasswordSecret = $input->getArgument('secret');
        $totPasswordRefreshPeriod = $input->getOption('refresh-period');

        $totPasswordAlgorithm = TotPasswordAlgorithm::create(
            $totPasswordSecret,
            $totPasswordRefreshPeriod
        );
        $totPassword = new TotPassword($totPasswordName, $totPasswordAlgorithm);

        $this->totPasswordRepository->register($totPassword);

        $output->writeln("<info>The new TOT password with name '$totPasswordName' was successfully registered.</info>");
    }
}
