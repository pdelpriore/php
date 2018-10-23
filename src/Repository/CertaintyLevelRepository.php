<?php

namespace App\Repository;

use App\Entity\CertaintyLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CertaintyLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method CertaintyLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method CertaintyLevel[]    findAll()
 * @method CertaintyLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CertaintyLevelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CertaintyLevel::class);
    }

//    /**
//     * @return CertaintyLevel[] Returns an array of CertaintyLevel objects
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
    public function findOneBySomeField($value): ?CertaintyLevel
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
