<?php

namespace App\Repository;

use App\Entity\CyllenePerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CyllenePerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method CyllenePerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method CyllenePerson[]    findAll()
 * @method CyllenePerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CyllenePersonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CyllenePerson::class);
    }

//    /**
//     * @return CyllenePerson[] Returns an array of CyllenePerson objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CyllenePerson
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
