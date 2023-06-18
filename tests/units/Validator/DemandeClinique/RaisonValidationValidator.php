<?php

namespace App\Validator\DemandeClinique\tests\units;

use App\Entity\DemandeClinique\Reponse;
use atoum\atoum;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RaisonValidationValidator extends atoum\test
{
    public function testValiderOk()
    {
        $this
            ->assert('Test de validation OK')
            ->given(
                $raisonValidation = $this->getRaisonValidation()
            )
            ->if(
                $raisonValidationValidator = $this->getTestedInstance()
            )
            ->then
                ->variable($raisonValidationValidator->valider($raisonValidation))
                    ->isNull()
        ;
    }

    public function testValiderKo()
    {
        $this
            ->assert('Test de validation KO')
            ->given(
                $raisonValidation = $this->getRaisonValidation([])
            )
            ->if(
                $raisonValidationValidator = $this->getTestedInstance()
            )
            ->then
                ->exception(function () use ($raisonValidationValidator, $raisonValidation) {
                    $raisonValidationValidator->valider($raisonValidation);
                })
                    ->isInstanceOf(BadRequestHttpException::class)
        ;
    }

    private function getRaisonValidation($reponses = true)
    {
        
        $raisonValidation = new \mock\App\Entity\DemandeClinique\RaisonValidation();
        if ($reponses) {
            $raisonValidation->getMockController()->getReponses = new ArrayCollection([new Reponse]);
        } else {

            $raisonValidation->getMockController()->getReponses = new ArrayCollection([]);
        }
        return $raisonValidation;
    }

    private function getTestedInstance()
    {
        return $this->newTestedInstance();
    }
}