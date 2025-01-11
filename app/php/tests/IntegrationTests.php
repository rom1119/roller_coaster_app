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
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\Exception\AccessException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

final class IntegrationTests extends WebTestCase
{
    // private CoasterFacade $coasterFacade;
    private ConstraintChecker $constraintChecker;
    private KernelBrowser $client;
    private CoasterFacade $coasterFacade;
    private ?PropertyAccessor $accessor = null;


    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->initTestsPersister();
        $container = self::getContainer()->get('test.service_container');
        $this->coasterFacade = $container->get(CoasterFacade::class);
        
    }


    protected function readResponseProperty(Response $response, $propertyPath): ?string
    {
        if ($this->accessor === null) {
            $this->accessor = PropertyAccess::createPropertyAccessor();
        }

        $data = json_decode((string)$response->getContent());

        if ($data === null) {
            return null;
        }

        try {
            return $this->accessor->getValue($data, $propertyPath);
        } catch (AccessException $e) {
            return null;
        }
    }
    
    public function initTestsPersister()
    {
        $containerTest = self::$kernel->getContainer()->get('test.service_container');
        $containerTest->set(CoasterPersister::class, new InMemoryCoasterPersister());
    }

    
    public function testAddCorrectWorkingCoaster(): void
    {
        $data = array(
            "liczba_personelu" => "50",
            "liczba_klientow" => "200",
            "dl_trasy" => "24",
            "godziny_od" => "7:10",
            "godziny_do" => "17:10",
        );

        $response = $this->client->request('POST', '/api/coasters', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            ],
            content: json_encode($data)
        );

        $res = $this->client->getResponse();

        $uuidCreated = json_decode($this->client->getResponse()->getContent())->uuid->uuid;
        $this->assertResponseStatusCodeSame(201);
        $this->assertNotNull($this->readResponseProperty($res, 'uuid.uuid'));

    }


    public function testDeleteWagon(): void
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


        $coasterCreated = $this->coasterFacade->findCoaster($coaster->getUuid());
        $this->assertEquals(1, $coasterCreated->totalWagons());
        $uuidCreated = $coaster->getUuid();
        $uuidWagonCreated = $coaster->getFirstWagon();

        $response = $this->client->request('DELETE', '/api/coasters/' . $uuidCreated->getUuid() . '/wagons/' . $uuidWagonCreated->getUuid()->getUuid());
        // dd($response);
        $this->assertResponseStatusCodeSame(204);

        $coasterCreated = $this->coasterFacade->findCoaster($coaster->getUuid());
        $this->assertEquals(0, $coasterCreated->totalWagons());

        // Validate a successful response and some content
        // $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Hello World');
    }
    
    public function testUpdateCoaster(): void
    {
        $coaster = new Coaster();
        $coaster->setDistance(4);
        $coaster->setNumberOfCustomers(100);
        $coaster->setNumberOfStaff(3);
        $coaster->setHourFrom('8:00');
        $coaster->setHourTo('16:00');
        $coaster = $this->coasterFacade->addCoaster($coaster);

        $uuidCreated = $coaster->getUuid();

        $dataUpdate = array(
            "liczba_personelu" => "50",
            "liczba_klientow" => "200",
            "godziny_od" => "07:10",
            "godziny_do" => "17:10",
        );
            
        $response = $this->client->request('PUT', '/api/coasters/' . $uuidCreated, 
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ],
            content: json_encode($dataUpdate)
        );

        $updated = json_decode($this->client->getResponse()->getContent());
        $uuidUpdated = $updated->uuid->uuid;

        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals((string)$uuidCreated, $uuidUpdated);

        $coaster = $this->coasterFacade->findCoaster($uuidCreated);

        $this->assertEquals((string)$dataUpdate['godziny_od'], $coaster->getHourFrom());


    }



}
