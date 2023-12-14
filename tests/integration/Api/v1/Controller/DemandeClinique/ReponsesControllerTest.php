<?php

declare(strict_types=1);

namespace integration\Api\v1\Controller\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Reponse;
use App\Repository\DemandeClinique\ReponseRepository;
use App\Tests\integration\WebFunctionalTestCase;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @coversDefaultClass \App\Api\v1\Controller\DemandeClinique\ReponsesController
 */
class ReponsesControllerTest extends WebFunctionalTestCase
{
    /**
     * @covers ::__construct
     * @covers ::validerReponses
     */
    public function testValiderReponses(): void
    {
        [$reponseA, $reponseB] = $this->getContext();
        $this->client->jsonRequest(
            Request::METHOD_POST,
            $this->urlGenerator->generate(
                'api_v1_reponse_valider'
            ),
            [
                'reponses' => [$reponseA->getId(), $reponseB->getId()],
                'reason' => 'raison'
            ]
        );

        self::assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        /** @var ReponseRepository $reponseRepo */
        $reponseRepo = $this->entityManager->getRepository(Reponse::class);

        $reponsesRetrouvees = $reponseRepo->findBy(['id' => [$reponseA->getId(), $reponseB->getId()]]);

        $this->assertTrue($reponsesRetrouvees[0]->estValidee());
        $this->assertEquals('raison', $reponsesRetrouvees[0]->getRaisonValidation());

        $this->assertTrue($reponsesRetrouvees[1]->estValidee());
        $this->assertEquals('raison', $reponsesRetrouvees[1]->getRaisonValidation());
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
