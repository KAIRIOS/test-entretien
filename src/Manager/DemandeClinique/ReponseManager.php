<?php

namespace App\Manager\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\RaisonValidation;
use App\Entity\DemandeClinique\Reponse;
use App\Factory\DemandeClinique\RaisonValidationFactory;
use App\Validator\DemandeClinique\ReponseValidator;
use App\Factory\DemandeClinique\ReponseFactory;
use App\Repository\DemandeClinique\ReponseRepository;
use App\Validator\DemandeClinique\RaisonValidationValidator;
use Doctrine\ORM\EntityManagerInterface;

class ReponseManager
{
    /** @var ReponseFactory $reponseFactory */
    private $reponseFactory;

    /** @var EntityManagerInterface $entityManagerInterface */
    private $entityManagerInterface;

    /** @var ReponseValidator $reponseValidator */
    private $reponseValidator;

    private $raisonValidationFactory;

    private $raisonValidationValidator; 

    public function __construct(ReponseFactory $reponseFactory, EntityManagerInterface $entityManagerInterface, ReponseValidator $reponseValidator, RaisonValidationFactory $raisonValidationFactory, RaisonValidationValidator $raisonValidationValidator)
    {
        $this->reponseFactory = $reponseFactory;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->reponseValidator = $reponseValidator;
        $this->raisonValidationFactory = $raisonValidationFactory;
        $this->raisonValidationValidator = $raisonValidationValidator;
    }

    public function creer(Depot $depot, string $titre, string $description, int $type): Reponse
    {
        $reponse = $this->reponseFactory->creer($depot, $titre, $description, $type);

        $this->reponseValidator->valider($reponse);

        $this->entityManagerInterface->persist($reponse);
        $this->entityManagerInterface->flush();

        return $reponse;
    }

    public function validerReponses(Array $reponses, string $description): RaisonValidation
    {

        foreach ($reponses as &$reponse) {
            $reponse->setEstValide(true);
        }

        $raisonValidation = $this->raisonValidationFactory->creer($reponses, $description);
    
        $this->raisonValidationValidator->valider($raisonValidation);

        $this->entityManagerInterface->persist($raisonValidation);
        $this->entityManagerInterface->flush();

        return $raisonValidation;

    }
}
