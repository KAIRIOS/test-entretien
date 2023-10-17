<?php

namespace App\Api\v1\Controller\DemandeClinique;

use App\Api\v1\DTO\Request\ReponsesValidationRequestDTO;
use App\Api\v1\Exceptions\ReponseNotFountException;
use App\Api\v1\Services\DepotsService;
use App\Entity\DemandeClinique\Depot;
use App\Manager\DemandeClinique\ReponseManager;
use App\Repository\DemandeClinique\DepotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @Route(
     *     "/validate/reponses",
     *     name="api_v1_depots_validate_reponse"
     *     methods={"POST"}
     * )
     */
    public function validateReponses(
        Request $request,
        DepotsService $depotsService,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {

        try {
            $reponsesValidationRequestDTO = $serializer->deserialize($request->getContent(), ReponsesValidationRequestDTO::class, JsonEncoder::FORMAT);

            $violations = $validator->validate($reponsesValidationRequestDTO);
            if (count($violations) > 0) {
                return $this->json($violations, Response::HTTP_BAD_REQUEST);
            }

            return $this->json(
                $depotsService->validateReponses($reponsesValidationRequestDTO),
                Response::HTTP_OK
            );
        } catch (ReponseNotFountException $exception) {
            return $this->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

}
