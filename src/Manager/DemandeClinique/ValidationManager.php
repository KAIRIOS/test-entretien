<?php

namespace App\Manager\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Validation;
use App\Factory\DemandeClinique\ValidationFactory;
use App\Validator\DemandeClinique\ValidationValidator;
use Doctrine\ORM\EntityManagerInterface;

class ValidationManager
{
	/** @var ValidationFactory $validationFactory */
	private $validationFactory;

	/** @var EntityManagerInterface $entityManagerInterface */
	private $entityManagerInterface;
	
	/** @var ValidationValidator $validationValidator */
	private $validationValidator;

	public function __construct(ValidationFactory $validationFactory, EntityManagerInterface $entityManagerInterface, ValidationValidator $validationValidator)
	{
		$this->entityManagerInterface = $entityManagerInterface;
		$this->validationFactory = $validationFactory;
		$this->validationValidator = $validationValidator;
	}

	public function creer(Depot $depot, string $raison, int $reponse): Validation
	{
		$validation = $this->validationFactory->creer($depot, $raison, $reponse);

		$this->validationValidator->valider($validation);

		$this->entityManagerInterface->persist($validation);
		$this->entityManagerInterface->flush();

		return $validation;
	}
}
