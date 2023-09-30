<?php

namespace App\Factory\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Reponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DemandeClinique\Validation;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidationFactory
{
	/** @var EntityManagerInterface $entityManagerInterface */
	private $entityManagerInterface;

	public function __construct(EntityManagerInterface $entityManagerInterface)
	{
		$this->entityManagerInterface = $entityManagerInterface;
	}

	public function creer(Depot $depot, string $raison, int $reponseId): Validation
	{
		$validation = new Validation();
		$validation->setDateCreation(new \DateTime());
		$validation->setDepot($depot);
		$validation->setRaison($raison);

		$validation->setReponse($this->getReponse($reponseId));

		return $validation;
	}

	public function getReponse(int $reponseId): ?Reponse
	{
			return $this->entityManagerInterface->getRepository(Reponse::class)->findOneById($reponseId);
	}
}
