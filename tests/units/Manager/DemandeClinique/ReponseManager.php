<?php

namespace App\Manager\DemandeClinique\tests\units;

use atoum\atoum;

class ReponseManager extends atoum\test
{
    private $entityManagerInterface;
    private $reponseFactory;
    private $reponseValidator;

    private $raisonValidationFactory;
    private $reponseRepository;
    private $raisonValidationValidator;

    public function beforeTestMethod($testMethod)
    {
        $this->entityManagerInterface = new \mock\Doctrine\ORM\EntityManagerInterface();

        $this->reponseFactory = new \mock\App\Factory\DemandeClinique\ReponseFactory();
        $this->reponseFactory->getMockController()->creer = $this->getReponse();

        $this->reponseValidator = new \mock\App\Validator\DemandeClinique\ReponseValidator();
        $this->reponseValidator->getMockController()->valider = null;

        $this->raisonValidationFactory = new \mock\App\Factory\DemandeClinique\RaisonValidationFactory();
        $this->raisonValidationFactory->getMockController()->creer = $this->getRaisonValidation();


        $this->raisonValidationValidator = new \mock\App\Validator\DemandeClinique\RaisonValidationValidator();
        $this->raisonValidationValidator->getMockController()->valider = null;
    }

    public function testCreerOk()
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
                $reponseManager = $this->getTestedInstance()
            )
            ->then
                ->object($reponseManager->creer($depot, $titre, $description, $type))
                    ->isInstanceOf(\App\Entity\DemandeClinique\Reponse::class)
                ->mock($this->reponseFactory)
                    ->call('creer')
                        ->withArguments($depot, $titre, $description, $type)
                        ->once()
                ->mock($this->reponseValidator)
                    ->call('valider')
                        ->withArguments($this->getReponse())
                        ->once()
                ->mock($this->entityManagerInterface)
                    ->call('persist')
                        ->withArguments($this->getReponse())
                        ->once()
                    ->call('flush')
                        ->once()
        ;
    }

    
    public function testValiderReponsesOK() {
        $this
            ->assert("Test de validation OK")
            ->given(
                $reponses = $this->getReponses(),
                $description = "test"
            )
            ->if(
                $reponseManager = $this->getTestedInstance()
            )
            ->then
                ->object($reponseManager->validerReponses($reponses, $description))
                    ->isInstanceOf(\App\Entity\DemandeClinique\RaisonValidation::class)
                ->mock($this->raisonValidationFactory)
                    ->call('creer')
                        ->withArguments($reponses, $description)
                        ->once()
                ->mock($this->entityManagerInterface)
                    ->call('persist')
                        ->withArguments($this->getRaisonValidation())
                        ->once()
                    ->call('flush')
                        ->once()
        ;
    }

    public function testValiderReponsesKO() {
        $this
            ->assert("Test de validation KO")
            ->given(
                $reponses = $this->getReponses(),
                $description = "test"
            )
            ->if(
                $this->raisonValidationValidator->getMockController()->valider = function () {
                    throw new \Exception('Erreur');
                },
                $reponseManager = $this->getTestedInstance()
            )
            ->then
                ->exception(function () use ($reponseManager, $reponses, $description) {
                    $reponseManager->validerReponses($reponses, $description);
                })
                    ->isInstanceOf(\Exception::class)
                    ->hasMessage('Erreur')
                ->mock($this->raisonValidationFactory)
                    ->call('creer')
                        ->withArguments($reponses, $description)
                        ->once()
                ->mock($this->raisonValidationValidator)
                    ->call('valider')
                        ->withArguments($this->getRaisonValidation())
                        ->once()
                ->mock($this->entityManagerInterface)
                    ->call('persist')
                        ->never()
                    ->call('flush')
                        ->never()
        ;
    }

    public function testCreerKo()
    {
        $this->assert('Test de création KO')
            ->given(
                $depot = $this->getDepot(),
                $titre = 'titre',
                $description = 'description',
                $type = 3
            )
            ->if(
                $this->reponseValidator->getMockController()->valider = function () {
                    throw new \Exception('Erreur');
                },
                $reponseManager = $this->getTestedInstance()
            )
            ->then
                ->exception(function () use ($reponseManager, $depot, $titre, $description, $type) {
                    $reponseManager->creer($depot, $titre, $description, $type);
                })
                    ->isInstanceOf(\Exception::class)
                    ->hasMessage('Erreur')
                ->mock($this->reponseFactory)
                    ->call('creer')
                        ->withArguments($depot, $titre, $description, $type)
                        ->once()
                ->mock($this->reponseValidator)
                    ->call('valider')
                        ->withArguments($this->getReponse())
                        ->once()
                ->mock($this->entityManagerInterface)
                    ->call('persist')
                        ->never()
                    ->call('flush')
                        ->never()
        ;
    }


    private function getReponse()
    {
        return new \mock\App\Entity\DemandeClinique\Reponse();
    }

    private function getReponses() {
        return [new \mock\App\Entity\DemandeClinique\Reponse()];
    }

    private function getDepot()
    {
        return new \mock\App\Entity\DemandeClinique\Depot();
    }

    private function getRaisonValidation() 
    {
        return new \mock\App\Entity\DemandeClinique\RaisonValidation();
    }

    private function getTestedInstance()
    {
        return $this->newTestedInstance(
            $this->reponseFactory,
            $this->entityManagerInterface,
            $this->reponseValidator,
            $this->raisonValidationFactory,
            $this->raisonValidationValidator
        );
    }
}