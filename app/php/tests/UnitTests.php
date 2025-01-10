<?php

declare(strict_types=1);

namespace App\Tests;

use App\Domain\CoasterFacade;
use App\Domain\CoasterPersister;
use App\Domain\ConstraintChecker;
use App\Domain\Model\Coaster;
use App\Domain\Model\CoasterID;
use App\Domain\Model\Wagon;
use App\Domain\Model\WagonID;
use App\Persister\InMemoryCoasterPersister;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UnitTests extends KernelTestCase
{
    private CoasterFacade $coasterFacade;
    private ConstraintChecker $constraintChecker;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer()->get('test.service_container');
        $container->set(CoasterPersister::class, new InMemoryCoasterPersister());
        $this->coasterFacade = $container->get(CoasterFacade::class);
        $this->constraintChecker = $container->get(ConstraintChecker::class);

    }

    protected function tearDown(): void
    {
    }


    
    public function testAddCorrectWorkingCoaster(): void
    {
        $coaster = new Coaster();
        $coaster->setUuid(CoasterID::create());
        $coaster->setDistance(4);
        $coaster->setNumberOfCustomers(100);
        $coaster->setNumberOfStaff(3);
        $coaster->setHourFrom('8:00');
        $coaster->setHourTo('16:00');
        $this->coasterFacade->addCoaster($coaster);

        $dbCoaster = $this->coasterFacade->findCoaster($coaster->getUuid());
        
        $wagon = new Wagon();
        $wagon->setUuid(WagonID::create());
        $wagon->setSpeed(4.4);
        $wagon->setNumberOfPlaces(100);
        $this->coasterFacade->addWagon($wagon, $coaster->getUuid());

        $checkedConstaints = $this->constraintChecker->check($coaster);
        $this->assertEmpty( $checkedConstaints );
    }

    public function testAddCoasterWithoutWagons(): void
    {
        $coaster = new Coaster();
        $coaster->setUuid(CoasterID::create());
        $coaster->setDistance(4);
        $coaster->setNumberOfCustomers(100);
        $coaster->setNumberOfStaff(2);
        $coaster->setHourFrom('8:00');
        $coaster->setHourTo('16:00');
        $this->coasterFacade->addCoaster($coaster);

        $checkedConstaints = $this->constraintChecker->check($coaster);
        $this->assertContains( 'Brakuje wagonów na 100 klientów', $checkedConstaints );
        $this->assertContains( 'W kolejce jest o 1 za dużo pracowników', $checkedConstaints );

    }

    public function testAddCoasterWithOverflowWagonPlaces(): void
    {
        $coaster = new Coaster();
        $coaster->setUuid(CoasterID::create());
        $coaster->setDistance(4);
        $coaster->setNumberOfCustomers(100);
        $coaster->setNumberOfStaff(2);
        $coaster->setHourFrom('8:00');
        $coaster->setHourTo('16:00');
        $this->coasterFacade->addCoaster($coaster);

        $wagon = new Wagon();
        $wagon->setUuid(WagonID::create());
        $wagon->setSpeed(4.4);
        $wagon->setNumberOfPlaces(101);
        $this->coasterFacade->addWagon($wagon, $coaster->getUuid());

        $checkedConstaints = $this->constraintChecker->check($coaster);

        $this->assertContains( 'Zbyt dużo wagonów w kolejce o 1 miejsc w wagonach jest nieużywanych', $checkedConstaints );
        $this->assertContains( 'Brakuje 1 pracowników', $checkedConstaints );

    }

}
