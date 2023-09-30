<?php

namespace App\Validator\DemandeClinique;

use App\Entity\DemandeClinique\Validation;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidationValidator
{
	public function valider(Validation $validation): void
	{
		if(!$validation->getReponse() || $validation->getReponse()->getDepot() !== $validation->getDepot()){
			throw new BadRequestHttpException('La reponse validée n’est pas valide');
		}
	}
}
