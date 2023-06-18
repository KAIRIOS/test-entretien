<?php

namespace App\Api\v1\Controller\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Manager\DemandeClinique\ReponseManager;
use App\Repository\DemandeClinique\DepotRepository;
use App\Repository\DemandeClinique\ReponseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/demande-clinique")
 */
class DepotsController extends AbstractController
{
    /** @var DepotRepository */
    private $depotRepository;

    /** @var ReponseManager */
    private $reponseManager;

    private $reponseRepository;

    public function __construct(DepotRepository $depotRepository, ReponseManager $reponseManager, ReponseRepository $reponseRepository)
    {
        $this->depotRepository = $depotRepository;
        $this->reponseManager = $reponseManager;
        $this->reponseRepository = $reponseRepository;
    }
    /**
     * @Route("/depots", name="api_v1_depots_all", methods={"GET"})
     */
    public function all(): JsonResponse
    {
        return $this->json($this->depotRepository->findAllByReponseLaPlusRecente());
    }

    /**
     * @Route("/depots/{id}/reponses", name="api_v1_depots_creer_reponse", methods={"POST"})
     */
    public function creerReponse(Depot $depot, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $this->reponseManager->creer($depot, $data['titre'], $data['description'], (int) $data['type']);

        return $this->json([], Response::HTTP_CREATED);
    }

    /**
     * @Route("/depots/reponses/validation", name="api_v1_depots_valider_reponses", methods={"PUT"})
     */
    public function validerReponses(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $reponses = $this->reponseRepository->findAllInArrayIds($data['ids']);


        $raisonValidation = $this->reponseManager->validerReponses($reponses, $data["description"]);

        return $this->json($raisonValidation, Response::HTTP_CREATED);
    }
}
