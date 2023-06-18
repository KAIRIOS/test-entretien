<?php

namespace App\Factory\DemandeClinique\tests\units;

use atoum\atoum;

class RaisonValidationFactory extends atoum\test
{
    public function testCreer()
    {
        $this
            ->assert('Test de création OK')
            ->given(
                $reponses = [],
                $description = 'description',
            )
            ->if(
                $reponseFactory = $this->getTestedInstance()
            )
            ->then
                ->object($reponseFactory->creer($reponses,  $description))
                    ->isInstanceOf(\App\Entity\DemandeClinique\RaisonValidation::class)
        ;
    }
    private function getTestedInstance()
    {
        return $this->newTestedInstance();
    }
}