<?php

namespace App\Api\v1\Controller\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Manager\DemandeClinique\ReponseManager;
use App\Manager\DemandeClinique\ValidationManager;
use App\Repository\DemandeClinique\DepotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Nous pourrions ajouter '/depots' directement ici au lieux de le mettre sur chaque route. 
/**
 * @Route("/demande-clinique")
 */
class DepotsController extends AbstractController
{
    /** @var DepotRepository */
    private $depotRepository;

    /** @var ReponseManager */
    private $reponseManager;

    /** @var ValidationManager */
    private $validationManager;

    public function __construct(DepotRepository $depotRepository, ReponseManager $reponseManager, ValidationManager $validationManager)
    {
        $this->depotRepository = $depotRepository;
        $this->reponseManager = $reponseManager;
        $this->validationManager = $validationManager;
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
     * @Route("/depots/{id}/valider", name="api_v1_depots_valider_reponse", methods={"POST"})
     */
    public function validerReponses(Depot $depot, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $this->validationManager->creer($depot, $data['raison'], $data['reponsesValidees']);

        return $this->json([], Response::HTTP_CREATED);
    }
}
