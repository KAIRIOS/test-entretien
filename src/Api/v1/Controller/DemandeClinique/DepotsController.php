<?php

namespace App\Api\v1\Controller\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Manager\DemandeClinique\ReponseManager;
use App\Repository\DemandeClinique\DepotRepository;
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

    public function __construct(DepotRepository $depotRepository, ReponseManager $reponseManager)
    {
        $this->depotRepository = $depotRepository;
        $this->reponseManager = $reponseManager;
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
     * @Route("/reponse/valider", name="api_v1_reponses_valider", methods={"POST"})
     */
    public function valider(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Pour les malins qui veulent enlever le disable du bouton dans l'inspecteur
        if(empty($data['reponse_ids']))
            return $this->json('Merci de laisser le DOM tranquille', Response::HTTP_BAD_REQUEST);

        $this->reponseManager->valider($data['reponse_ids'], $data['justification']);

        return $this->json([], Response::HTTP_OK);

    }
}
