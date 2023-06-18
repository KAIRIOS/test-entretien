<?php 

namespace App\Factory\DemandeClinique;

use App\Entity\DemandeClinique\RaisonValidation;
use DateTime;

class RaisonValidationFactory
{
    public function creer(Array $reponses, string $description) : RaisonValidation {
        return (new RaisonValidation())
            ->setReponses($reponses)
            ->setDescription($description)
            ->setDateCreation(new DateTime());
    }
}