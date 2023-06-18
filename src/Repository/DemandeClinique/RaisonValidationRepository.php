<?php

namespace App\Repository\DemandeClinique;

use App\Entity\DemandeClinique\RaisonValidation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaisonValidation>
 *
 * @method RaisonValidation|null find($id, $lockMode = null, $lockVersion = null)
 * @method RaisonValidation|null findOneBy(array $criteria, array $orderBy = null)
 * @method RaisonValidation[]    findAll()
 * @method RaisonValidation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaisonValidationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaisonValidation::class);
    }

    public function add(RaisonValidation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RaisonValidation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RaisonValidation[] Returns an array of RaisonValidation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RaisonValidation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
