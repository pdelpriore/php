<?php

namespace App\Repository;

use App\Entity\InChargePerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InChargePerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method InChargePerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method InChargePerson[]    findAll()
 * @method InChargePerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InChargePersonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InChargePerson::class);
    }

//    /**
//     * @return InChargePerson[] Returns an array of InChargePerson objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InChargePerson
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
