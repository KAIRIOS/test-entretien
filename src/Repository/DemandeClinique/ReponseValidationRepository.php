<?php

namespace App\Repository\DemandeClinique;

use App\Dao\CreerReponseValidation;
use App\Entity\DemandeClinique\Reponse;
use App\Entity\DemandeClinique\ReponseValidation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

/**
 * @extends ServiceEntityRepository<ReponseValidation>
 *
 * @method ReponseValidation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponseValidation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponseValidation[]    findAll()
 * @method ReponseValidation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseValidationRepository extends ServiceEntityRepository
{
    /**
     * @var ReponseRepository
     */
    private $reponseRepository;

    public function __construct(
        ManagerRegistry $registry,
        ReponseRepository $reponseRepository
    ) {
        parent::__construct($registry, ReponseValidation::class);
        $this->reponseRepository = $reponseRepository;
    }

    public function add(ReponseValidation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReponseValidation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function creer(CreerReponseValidation $creerReponseValidation): void
    {
        /** @var Reponse[] $reponses */
        $reponses = $this->reponseRepository->findBy(['id' => $creerReponseValidation->idReponses]);

        $reponseValidation = new ReponseValidation();

        array_walk($reponses, static function ($reponse) use ($reponseValidation) {
            $reponseValidation->addReponse($reponse);
        });

        $reponseValidation->setDescription($creerReponseValidation->description);

        $this->getEntityManager()->persist($reponseValidation);
        $this->getEntityManager()->flush();
    }
}
