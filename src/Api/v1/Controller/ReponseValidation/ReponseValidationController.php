<?php

namespace App\Api\v1\Controller\ReponseValidation;

use App\Dao\CreerReponseValidation;
use App\Repository\DemandeClinique\ReponseValidationRepository;
use App\Validator\DemandeClinique\CreerReponseValidationValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reponse_validation")
 */
class ReponseValidationController extends AbstractController
{

    /**
     * @var ReponseValidationRepository
     */
    private $responseValidationRepository;
    /**
     * @var CreerReponseValidationValidator
     */
    private $creerReponseValidationValidator;

    public function __construct(
        ReponseValidationRepository $responseValidationRepository,
        CreerReponseValidationValidator $creerReponseValidationValidator
    ) {
        $this->responseValidationRepository = $responseValidationRepository;
        $this->creerReponseValidationValidator = $creerReponseValidationValidator;
    }
    /**
     * @Route("/creer", name="api_v1_valide_reponse", methods={"POST"})
     */
    public function valide(Request $request): Response
    {
        $creerReponseValidation = CreerReponseValidation::denormalizer($request->toArray());

        $this->creerReponseValidationValidator->valider($creerReponseValidation);

        $this->responseValidationRepository->creer($creerReponseValidation);

        return new Response();
    }
}