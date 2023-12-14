<?php

declare(strict_types=1);

namespace App\Tests\integration\Repository\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Reponse;
use App\Repository\DemandeClinique\ReponseRepository;
use App\Tests\integration\FunctionalTestCase;
use DateTime;

/**
 * @coversDefaultClass ReponseRepository
 */
class ReponseRepositoryTest extends FunctionalTestCase
{
    /**
     * @covers ::__construct
     * @covers ::validate
     */
    public function testValidate(): void
    {
        [$reponseA, $reponseB] = $this->getContext();

        /** @var ReponseRepository $reponseRepo */
        $reponseRepo = $this->entityManager->getRepository(Reponse::class);
        $reponseRepo->validate([$reponseA->getId()], 'raison');
        $reponsesRetrouvees = $reponseRepo->findBy(['id' => [$reponseA->getId(), $reponseB->getId()]]);

        $this->assertTrue($reponsesRetrouvees[0]->estValidee());
        $this->assertEquals('raison', $reponsesRetrouvees[0]->getRaisonValidation());

        $this->assertFalse($reponsesRetrouvees[1]->estValidee());
        $this->assertNull($reponsesRetrouvees[1]->getRaisonValidation());
    }

    /**
     * @return Reponse[]
     */
    private function getContext(): array
    {
        $depot = new Depot();
        $depot
            ->setDescription('desc')
            ->setTitre('titre')
            ->setDateCreation(new DateTime());

        $this->entityManager->persist($depot);

        $reponseA = $this->reponseManager->creer($depot, 'titre reponse A', 'description réponse A', 1);
        $reponseB = $this->reponseManager->creer($depot, 'titre reponse B', 'description réponse B', 2);

        $this->entityManager->persist($reponseA);
        $this->entityManager->persist($reponseB);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return [$reponseA, $reponseB];
    }
}
