<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Person>
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    //    /**
    //     * @return Person[] Returns an array of Person objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function create($person): ?Person
    {
        $isNisInvalid = true;

        do {
            $nis = $person->generateNis();
            $isNisInvalid = $this->findOneByNis($nis);
        } while ($isNisInvalid);

        $person->setNis($nis);

        $this->getEntityManager()->persist($person);
        $this->getEntityManager()->flush();

        return $person;
    }

    public function findOneByNis($value): ?Person
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.nis = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
