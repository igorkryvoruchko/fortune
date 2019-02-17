<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 17.02.19
 * Time: 17:02
 */

namespace AppBundle\Command;

use AppBundle\Controller\MoneyController;
use AppBundle\WinningsActions\Extensions\MoneyServices;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class moneyToBankCommand extends Command
{

    private $moneyController;

    public function __construct(MoneyController $moneyController)
    {
        $this->moneyController = $moneyController;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setName('money:to:bank')
            ->setDescription('moneyToBankCommand')
            ->addArgument(
                'id',
                InputArgument::OPTIONAL,
                'Who do you want to greet?'
            )
            ->addOption(
                'yell',
                null,
                InputOption::VALUE_NONE,
                'If set, the task will yell in uppercase letters'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hello = $this->moneyController->moneyToBankCommandForAction($input->getArgument('id'));

        $output->writeln($hello);
    }
}