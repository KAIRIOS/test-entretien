<?php

namespace App\Validator\DemandeClinique;

use App\Entity\DemandeClinique\Reponse;
use App\Enum\DemandeClinique\Reponse\Type;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ReponseValidator
{
    public function valider(Reponse $reponse): void
    {
        if (in_array($reponse->getType(), Type::getAll()) === false) {
            throw new BadRequestHttpException('Le type de réponse n\'est pas valide');
        }
        if($reponse->getMotifValidation() === null && $reponse->getType() === Type::VALIDEE){
            throw new BadRequestHttpException('Le motif de validation est obligatoire pour une réponse validée');
        }
        if($reponse->getMotifValidation() !== null && $reponse->getType() !== Type::VALIDEE){
            throw new BadRequestHttpException('Une réponse doit être validée pour avoir un motif de validation');
        }
    }
}