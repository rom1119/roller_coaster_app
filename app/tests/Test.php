<?php

declare(strict_types=1);

namespace App\Tests;


use PHPUnit\Framework\TestCase;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class Test extends KernelTestCase
{
    private Facade $Facade;
    // public function __construct(
    //     // private Persister $persister,
    // ) {
    // }

    protected function setUp(): void
    {
        self::bootKernel();
        $this->Facade = self::getContainer()->get(Facade::class);

    }

    protected function tearDown(): void
    {
    }


    
    public function testMainCasesWithExcluding(): void
    {
        $db = new InMemoryPersister();

        $this->assertSame(3, actual: count($result));


    }

}
