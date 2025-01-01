<?php

namespace App\Persister;

use App\Domain\CoasterPersister;
use App\Entity\Coaster;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseCoasterPersister implements CoasterPersister
{

    public function __construct(private EntityManagerInterface $em) {
        
    }

    public function persist( $model):  Coaster
    {

        $Coaster = new Coaster();

        $this->em->persist($Coaster);
        $this->em->flush();

        return $Coaster;
        
    }


    public function getAllSchedules(string $filter = 'all', int $limit = 4): array
    {
        return $this->em->getRepository(Coaster::class)->findByFilter($filter, $limit);
    }
}
