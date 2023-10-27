<?php

namespace App\Validator\DemandeClinique;

use App\Dao\CreerReponseValidation;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreerReponseValidationValidator
{
    public function valider(CreerReponseValidation $creerReponseValidation): void {
        if (count($creerReponseValidation->idReponses) === 0) {
            throw new BadRequestHttpException('Il faut au moins une réponse');
        }

        if (strlen($creerReponseValidation->description) === 0) {
            throw new BadRequestHttpException('Il faut une description');
        }

        if (strlen($creerReponseValidation->description) > 255) {
            throw new BadRequestHttpException('La description est trop longue');
        }

        foreach ($creerReponseValidation->idReponses as $idReponse) {
            if (is_int($idReponse) === false) {
                throw new BadRequestHttpException('L\'id d\'une réponse doit être un entier');
            }
        }
    }
}