<?php

namespace App\Manager\DemandeClinique\tests\units;

use App\Entity\DemandeClinique\Reponse;
use atoum\atoum;
use Exception;
use mock\Doctrine\ORM\EntityManagerInterface;
use mock\App\Entity\DemandeClinique\Reponse as MockResponse;
use mock\App\Entity\DemandeClinique\Depot;
use mock\App\Factory\DemandeClinique\ReponseFactory;
use mock\App\Validator\DemandeClinique\ReponseValidator;
use mock\Repository\DemandeClinique\ReponseRepository;

class ReponseManager extends atoum\test
{
    private EntityManagerInterface $entityManagerInterface;
    private ReponseFactory $reponseFactory;
    private ReponseValidator $reponseValidator;
    public function beforeTestMethod($testMethod): void
    {
        $this->entityManagerInterface = new EntityManagerInterface();
        $this->entityManagerInterface->getMockController()->getRepository = new ReponseRepository();

        $this->reponseFactory = new ReponseFactory();
        $this->reponseFactory->getMockController()->creer = $this->getReponse();

        $this->reponseValidator = new ReponseValidator();
        $this->reponseValidator->getMockController()->valider = null;
    }

    public function testCreerOk(): void
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
                    ->isInstanceOf(Reponse::class)
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

    public function testCreerKo(): void
    {
        $this->assert('Test de création KO')
            ->given(
                $depot = $this->getDepot(),
                $titre = 'titre',
                $description = 'description',
                $type = 5
            )
            ->if(
                $this->reponseValidator->getMockController()->valider = static function () {
                    throw new Exception('Erreur');
                },
                $reponseManager = $this->getTestedInstance()
            )
            ->then
                ->exception(function () use ($reponseManager, $depot, $titre, $description, $type) {
                    $reponseManager->creer($depot, $titre, $description, $type);
                })
                    ->isInstanceOf(Exception::class)
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

    public function testValiderOk(): void
    {
        $this->assert('Test de validation OK')
                ->if(
                    $reponseManager = $this->getTestedInstance()
                )
                ->then
                    ->variable($reponseManager->valider([1], 'raison'))
                    ->mock($this->entityManagerInterface)
                        ->call('getRepository')
                        ->withArguments(Reponse::class)
                        ->once()
        ;
    }

    private function getReponse(): MockResponse
    {
        return new MockResponse();
    }

    private function getDepot(): Depot
    {
        return new Depot();
    }

    private function getTestedInstance()
    {
        return $this->newTestedInstance(
            $this->reponseFactory,
            $this->entityManagerInterface,
            $this->reponseValidator
        );
    }
}
