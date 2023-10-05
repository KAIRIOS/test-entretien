<?php

namespace App\Manager\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Reponse;
use App\Factory\DemandeClinique\ReponseFactory;
use App\Validator\DemandeClinique\ReponseValidator;
use App\Workflow\DemandeClinique\ReponseWorkflow;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ReponseManager
{
    /** @var ReponseFactory $reponseFactory */
    private $reponseFactory;

    /** @var EntityManagerInterface $entityManagerInterface */
    private $entityManagerInterface;

    /** @var ReponseValidator $reponseValidator */
    private $reponseValidator;

    /** @var ReponseWorkflow */
    private $reponseWorkflow;

    public function __construct(ReponseFactory $reponseFactory, EntityManagerInterface $entityManagerInterface, ReponseValidator $reponseValidator, ReponseWorkflow $reponseWorkflow)
    {
        $this->reponseFactory = $reponseFactory;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->reponseValidator = $reponseValidator;
        $this->reponseWorkflow = $reponseWorkflow;
    }

    public function creer(Depot $depot, string $titre, string $description, int $type): Reponse
    {
        $reponse = $this->reponseFactory->creer($depot, $titre, $description, $type);

        $this->reponseValidator->valider($reponse);

        $this->entityManagerInterface->persist($reponse);
        $this->entityManagerInterface->flush();

        return $reponse;
    }

    public function validerPlusieurs(array $data): void
    {
        if (false === array_key_exists('reponseIds', $data)) {
            throw new BadRequestHttpException();
        }

        $reponses = $this->entityManagerInterface->getRepository(Reponse::class)->findBy(['id' => $data['reponseIds']]);

        $this->reponseWorkflow->validateMany($reponses, $data['comment'] ?? null);
        $this->entityManagerInterface->flush();
    }
}
