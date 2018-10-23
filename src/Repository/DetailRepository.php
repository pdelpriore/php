<?php

namespace App\Repository;

use App\Entity\Detail;
use App\Entity\Header;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Detail|null find($id, $lockMode = null, $lockVersion = null)
 * @method Detail|null findOneBy(array $criteria, array $orderBy = null)
 * @method Detail[]    findAll()
 * @method Detail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Detail::class);
    }

//    /**
//     * @return Detail[] Returns an array of Detail objects
//     */

    public function findByActivityGroup(Header $h)
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.activityGroup', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Detail
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
