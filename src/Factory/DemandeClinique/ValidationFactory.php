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

	public function creer(Depot $depot, string $raison, array $reponsesId): Validation
	{
		$validation = new Validation();
		$validation->setDateCreation(new \DateTime());
		$validation->setDepot($depot);
		$validation->setRaison($raison);

		$reponses = $this->getReponses($reponsesId, $depot);
		foreach ($reponses as $reponse) {
			$validation->addResponse($reponse);
		}

		return $validation;
	}

	public function getReponses(array $reponsesId, Depot $depot): array
	{
		$reponses = [];
		foreach ($reponsesId as $reponseId) {
			$reponse = $this->entityManagerInterface->getRepository(Reponse::class)->findOneById($reponseId);

			if (!$reponse || $reponse->getDepot() !== $depot) {
				throw new BadRequestHttpException('La sélection de réponse n’est pas valide');
			}

			$reponses[] = $reponse;
		}

		return $reponses;
	}
}
