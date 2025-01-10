<?php
namespace App\Command;

use App\Domain\StatisticMonitoring;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


// the name of the command is what  type after "php bin/console"
#[AsCommand(name: 'app:roller-coasters-monitoring')]
class RollerCoastersMonitoringCommand extends Command
{
    public function __construct(
        private StatisticMonitoring $redisMonitoring,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {


        $this->redisMonitoring->runMonitoring();
        
        if (false) {


            // $this->em->persist();
            // $this->em->flush();

        }
        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;


    }
}