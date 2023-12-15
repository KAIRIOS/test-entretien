<?php

namespace App\Factory\DemandeClinique\tests\units;

use App\Entity\DemandeClinique\Reponse;
use atoum\atoum;
use mock\App\Entity\DemandeClinique\Depot;

class ReponseFactory extends atoum\test
{
    public function testCreer(): void
    {
        $this
            ->assert('Test de création OK')
            ->given(
                $depot = $this->getDepot(),
                $titre = 'titre',
                $description = 'description',
                $type = 1
            )
            ->if(
                $reponseFactory = $this->getTestedInstance()
            )
            ->then
                ->object($reponseFactory->creer($depot, $titre, $description, $type))
                    ->isInstanceOf(Reponse::class)
        ;
    }

    private function getDepot(): Depot
    {
        return new Depot();
    }

    private function getTestedInstance()
    {
        return $this->newTestedInstance();
    }
}
