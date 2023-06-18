<?php

namespace App\Validator\DemandeClinique;

use App\Entity\DemandeClinique\RaisonValidation;
use App\Entity\DemandeClinique\Reponse;
use App\Enum\DemandeClinique\Reponse\Type;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RaisonValidationValidator
{
    public function valider(RaisonValidation $raisonValidation): void
    {
        if (count($raisonValidation->getReponses()) <= 0) {
            throw new BadRequestHttpException('Les réponses de la raison ne sont pas valide');
        }
    }
}