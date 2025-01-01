<?php

namespace App\Repository;

use App\Entity\Coaster;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coaster>
 */
class CoasterRepository extends ServiceEntityRepository 
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coaster::class);
    }


       /**
     * Find  by filter.
     *
     * @param string $filter
     * @return array
     */
    public function findByFilter(string $filter = 'all', int $limit = 4): array
    {
        $queryBuilder = $this->createQueryBuilder('c');

        if ($filter === 'not_excluded') {
            $queryBuilder->andWhere('c.excluded = :excluded')
                ->setParameter('excluded', false);
        }

        return $queryBuilder
            ->orderBy('c.totalInterest', 'DESC')
            ->addOrderBy('c.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
