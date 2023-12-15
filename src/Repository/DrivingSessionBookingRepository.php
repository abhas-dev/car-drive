<?php

namespace App\Repository;

use App\Entity\DrivingSessionBooking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DrivingSessionBooking>
 *
 * @method DrivingSessionBooking|null find($id, $lockMode = null, $lockVersion = null)
 * @method DrivingSessionBooking|null findOneBy(array $criteria, array $orderBy = null)
 * @method DrivingSessionBooking[]    findAll()
 * @method DrivingSessionBooking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrivingSessionBookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DrivingSessionBooking::class);
    }

//    /**
//     * @return DrivingSessionBooking[] Returns an array of DrivingSessionBooking objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DrivingSessionBooking
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
