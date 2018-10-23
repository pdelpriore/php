<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\ActivityGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    /**
     * @return Activity[] Returns an array of Activity objects
     */

    public function findAndSortBySerialNumber($activityGroup)
    {
        return $this->createQueryBuilder('a')
            ->where('a.activityGroup = :activityGroup')
            ->setParameter('activityGroup', $activityGroup)
            ->orderBy('a.serialNumber', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Activity
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllOrderBySerialNumber(ActivityGroup $activityGroup): array
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT a
        FROM App\Entity\Activity a
        WHERE a.activityGroup = :activityGroup
        ORDER BY a.serialNumber ASC'
        );
        $query->setParameter('activityGroup', $activityGroup->getId());

        // returns an array of Product objects
        return $query->execute();
    }
}
