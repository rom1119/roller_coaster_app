<?php
namespace App\Command;

use App\Domain\CoasterFacade;
use App\Domain\Model\Coaster;
use App\Domain\Model\Wagon;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


// the name of the command is what  type after "php bin/console"
#[AsCommand(name: 'app:init-roller-coasters')]
class InitRollerCoastersCommand extends Command
{
    public function __construct(
        private CoasterFacade $coasterFacade
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $coaster = new Coaster();
        $coaster->setDistance(4);
        $coaster->setNumberOfCustomers(100);
        $coaster->setNumberOfStaff(3);
        $coaster->setHourFrom('8:00');
        $coaster->setHourTo('16:00');
        $coaster = $this->coasterFacade->addCoaster($coaster);

        $wagon = new Wagon();
        $wagon->setNumberOfPlaces(10);
        $wagon->setSpeed(speed: 4.5);
        $coaster = $this->coasterFacade->addWagon($wagon, $coaster->getUuid());

        $output->writeln('added one coaster w ID=' . $coaster->getUuid());
        return Command::SUCCESS;


    }
}