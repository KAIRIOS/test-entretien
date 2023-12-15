<?php

namespace App\Normalizer\DemandeClinique\tests\units;

use atoum\atoum;
use mock\App\Entity\DemandeClinique\Reponse;
use mock\App\Entity\DemandeClinique\Depot;

class ReponseNormalizer extends atoum\test
{
    public function testNormalize(): void
    {
        $this
            ->assert('Test de normalisation OK')
            ->given(
                $reponse = $this->getReponse()
            )
            ->if(
                $reponseNormalizer = $this->getTestedInstance()
            )
            ->then
                ->array($reponseNormalizer->normalize($reponse))
                    ->isEqualTo([
                        'id' => 1,
                        'date_creation' => '2019-01-01 00:00:00',
                        'titre' => 'titre',
                        'description' => 'description',
                        'type' => 1,
                        'depot' => 1,
                        'est_validee' => true,
                        'validation_raison' => 'raison'
                    ])
        ;
    }

    public function testSupportsNormalization(): void
    {
        $this->assert('Mauvais objet de normalisation')
            ->given($objet = $this->getDepot())
            ->if(
                $depotNormalizer = $this->getTestedInstance()
            )
            ->then
            ->boolean($depotNormalizer->supportsNormalization($objet))
            ->isFalse();
    }

    private function getReponse(): Reponse
    {
        $reponse = new Reponse();
        $this->calling($reponse)->getId = 1;
        $this->calling($reponse)->getDateCreation = new \DateTime('2019-01-01 00:00:00');
        $this->calling($reponse)->getTitre = 'titre';
        $this->calling($reponse)->getDescription = 'description';
        $this->calling($reponse)->getType = 1;
        $this->calling($reponse)->getDepot = $this->getDepot();
        $this->calling($reponse)->estValidee = true;
        $this->calling($reponse)->getRaisonValidation = 'raison';

        return $reponse;
    }

    private function getDepot(): Depot
    {
        $depot = new Depot();
        $this->calling($depot)->getId = 1;

        return $depot;
    }

    private function getTestedInstance()
    {
        return $this->newTestedInstance();
    }
}
