<?php

namespace App\Api\v1\Controller\DemandeClinique;

use App\Entity\DemandeClinique\Reponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Manager\DemandeClinique\ReponseManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * @Route("/demande-clinique")
 */
class ReponsesController extends AbstractController
{
    /** @var ReponseManager */
    private $reponseManager;

    public function __construct(ReponseManager $reponseManager)
    {
        $this->reponseManager = $reponseManager;
    }

    /**
     * @Route("/reponses/{id}/valider", name="api_v1_reponses_valider_reponse", methods={"POST"})
     */
    public function valider(Reponse $reponse, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data) || !array_key_exists('raisonValidation', $data) || null === $data['raisonValidation']) {
            throw new BadRequestException('raisonValidation is required.');
        }

        $this->reponseManager->valider($reponse, $data['raisonValidation']);

        return $this->json([], Response::HTTP_OK);
    }
}
