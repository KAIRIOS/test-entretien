<?php

namespace App\Repository\DemandeClinique;

use App\Entity\DemandeClinique\Reponse;
use App\Entity\DemandeClinique\ReponseWorkflowLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReponseWorkflowLog>
 *
 * @method ReponseWorkflowLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponseWorkflowLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponseWorkflowLog[]    findAll()
 * @method ReponseWorkflowLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseWorkflowLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReponseWorkflowLog::class);
    }

    public function findLatestByReponse(Reponse $reponse): ?ReponseWorkflowLog
    {
        $qb = $this->createQueryBuilder('rwl')
            ->andWhere('rwl.reponse = :reponse')
            ->addOrderBy('rwl.createdAt', 'DESC')

            ->setParameter('reponse', $reponse)
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
