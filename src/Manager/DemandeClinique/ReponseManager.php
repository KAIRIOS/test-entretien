<?php

namespace App\Manager\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Reponse;
use App\Repository\DemandeClinique\ReponseRepository;
use App\Validator\DemandeClinique\ReponseValidator;
use App\Factory\DemandeClinique\ReponseFactory;
use Doctrine\ORM\EntityManagerInterface;

class ReponseManager
{
    /**
     * @var ReponseFactory $reponseFactory
     */
    private ReponseFactory $reponseFactory;

    /**
     * @var EntityManagerInterface $entityManagerInterface
     */
    private EntityManagerInterface $entityManagerInterface;

    /**
     * @var ReponseValidator $reponseValidator
     */
    private ReponseValidator $reponseValidator;

    public function __construct(ReponseFactory $reponseFactory, EntityManagerInterface $entityManagerInterface, ReponseValidator $reponseValidator)
    {
        $this->reponseFactory = $reponseFactory;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->reponseValidator = $reponseValidator;
    }

    public function creer(Depot $depot, string $titre, string $description, int $type): Reponse
    {
        $reponse = $this->reponseFactory->creer($depot, $titre, $description, $type);
        $this->reponseValidator->valider($reponse);

        $this->entityManagerInterface->persist($reponse);

        $this->entityManagerInterface->flush();

        return $reponse;
    }

    /**
     * @param int[] $reponsesId
     * @param string $raison
     */
    public function valider(array $reponsesId, string $raison): void
    {
        /** @var ReponseRepository $repo */
        $repo = $this->entityManagerInterface->getRepository(Reponse::class);

        $repo->validate($reponsesId, $raison);
    }
}
