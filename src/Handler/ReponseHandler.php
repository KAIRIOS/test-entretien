<?php

namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use App\Manager\DemandeClinique\ReponseManager;
use App\Entity\DemandeClinique\Reponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;

class ReponseHandler
{
    private ReponseManager $reponseManager;
    private ValidatorInterface $validator;

    public function __construct(ReponseManager $reponseManager, ValidatorInterface $validator) {
        $this->reponseManager = $reponseManager;
        $this->validator = $validator;
    }

    public function validate(Reponse $reponse): JsonResponse
    {
        $reponse->setValidee(true);

        $errors = $this->validator->validate($reponse);

        if (count($errors) > 0) {
            return new JsonResponse((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);                   
        }

        $this->reponseManager->save($reponse);
        return new JsonResponse("validated", Response::HTTP_OK);
    }
}