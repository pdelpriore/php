<?php

namespace App\Repository;

use App\Entity\Header;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Header|null find($id, $lockMode = null, $lockVersion = null)
 * @method Header|null findOneBy(array $criteria, array $orderBy = null)
 * @method Header[]    findAll()
 * @method Header[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeaderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Header::class);
    }

//    /**
//     * @return Header[] Returns an array of Header objects
//     */
/*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
*/

    /*
    public function findOneBySomeField($value): ?Header
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

public function findElement($billing) {
    $em = $this->getEntityManager();

    $query = $em->createQuery(
        'SELECT h
        FROM App\Entity\Header h
        WHERE h.billing = :billing
        ORDER BY h.created_on DESC
        '
    )->setParameter('billing', $billing);

    return $query->execute();
}

    public function findAllRevisions($title): array
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.title = :title')
            ->setParameter('title', $title)
            ->orderBy('h.estimate_version', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
