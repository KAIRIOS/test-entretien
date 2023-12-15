<?php

namespace App\Validator\DemandeClinique\tests\units;

use atoum\atoum;
use mock\App\Entity\DemandeClinique\Reponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ReponseValidator extends atoum\test
{
    public function testValiderOk(): void
    {
        $this
            ->assert('Test de validation OK')
            ->given(
                $reponse = $this->getReponse()
            )
            ->if(
                $reponseValidator = $this->getTestedInstance()
            )
            ->then
                ->variable($reponseValidator->valider($reponse))
                    ->isNull()
        ;
    }

    public function testValiderKo(): void
    {
        $this
            ->assert('Test de validation KO')
            ->given(
                $reponse = $this->getReponse(6)
            )
            ->if(
                $reponseValidator = $this->getTestedInstance()
            )
            ->then
                ->exception(function () use ($reponseValidator, $reponse) {
                    $reponseValidator->valider($reponse);
                })
                    ->isInstanceOf(BadRequestHttpException::class)
        ;
    }

    private function getReponse($type = 1): Reponse
    {
        $reponse = new Reponse();
        $reponse->getMockController()->getType = $type;

        return $reponse;
    }

    private function getTestedInstance()
    {
        return $this->newTestedInstance();
    }
}
