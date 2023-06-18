<?php

namespace App\Manager\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Reponse;
use App\Validator\DemandeClinique\ReponseValidator;
use App\Factory\DemandeClinique\ReponseFactory;
use App\Repository\DemandeClinique\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;

class ReponseManager
{
    /** @var ReponseFactory $reponseFactory */
    private $reponseFactory;

    /** @var EntityManagerInterface $entityManagerInterface */
    private $entityManagerInterface;

    /** @var ReponseValidator $reponseValidator */
    private $reponseValidator;

    /** @var ReponseRepository $reponseRepository */
    private $reponseRepository;

    public function __construct(ReponseFactory $reponseFactory, EntityManagerInterface $entityManagerInterface, ReponseValidator $reponseValidator, ReponseRepository $reponseRepository)
    {
        $this->reponseFactory = $reponseFactory;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->reponseValidator = $reponseValidator;
        $this->reponseRepository = $reponseRepository;
    }

    public function creer(Depot $depot, string $titre, string $description, int $type): Reponse
    {
        $reponse = $this->reponseFactory->creer($depot, $titre, $description, $type);

        $this->reponseValidator->valider($reponse);

        $this->entityManagerInterface->persist($reponse);
        $this->entityManagerInterface->flush();

        return $reponse;
    }

    public function valider(array $reponse_ids, string $justification): bool {
        $reponses = $this->reponseRepository->findBy(['id' => $reponse_ids]);
        foreach($reponses as $reponse) {
            $reponse->setJustificationValidation($justification);
            $this->entityManagerInterface->persist($reponse);
        }

        $this->entityManagerInterface->flush();

        return true;
    }
}
