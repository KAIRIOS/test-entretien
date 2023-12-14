<?php

namespace App\Api\v1\Controller\DemandeClinique;

use App\Manager\DemandeClinique\ReponseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/demande-clinique")
 */
class ReponsesController extends AbstractController
{
    /**
     * @var ReponseManager
     */
    private $reponseManager;
    public function __construct(ReponseManager $reponseManager)
    {
        $this->reponseManager = $reponseManager;
    }

    /**
     * @Route("/reponses/validation", name="api_v1_reponse_valider", methods={"POST"})
     */
    public function validerReponses(Request $request): JsonResponse
    {
        [$responses, $reason] = array_values(json_decode($request->getContent(), true));

        $this->reponseManager->valider($responses, $reason);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
