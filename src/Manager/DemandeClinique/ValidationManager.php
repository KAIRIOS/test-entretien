<?php

namespace App\Manager\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Reponse;
use App\Entity\DemandeClinique\Validation;
use App\Factory\DemandeClinique\ValidationFactory;
use Doctrine\ORM\EntityManagerInterface;

class ValidationManager
{
    /** @var ValidationFactory $validationFactory */
    private $validationFactory;

    /** @var EntityManagerInterface $entityManagerInterface */
    private $entityManagerInterface;

    public function __construct(ValidationFactory $validationFactory, EntityManagerInterface $entityManagerInterface )
    {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->validationFactory = $validationFactory;
    }

    public function creer(Depot $depot, string $raison, string $reponses): Validation
    {
        $validation = $this->validationFactory->creer($depot, $raison, json_decode($reponses));

        $this->entityManagerInterface->persist($validation);
        $this->entityManagerInterface->flush();

        return $validation;
    }
}
