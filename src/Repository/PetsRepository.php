<?php

namespace App\Repository;

use App\Entity\Pets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as DoctrineManagerRegistry;
use Doctrine\ORM\EntityRepository;

/**
 * Class_
 * 
 * 
 */
class PetsRepository extends EntityRepository
{
    public function getCountPets()
    {
        return $this->createQueryBuilder('c')
            ->select('count(pets.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
