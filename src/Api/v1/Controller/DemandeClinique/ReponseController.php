<?php

namespace App\Api\v1\Controller\DemandeClinique;

use App\Entity\DemandeClinique\Reponse;
use App\Manager\DemandeClinique\ReponseManager;
use App\Repository\DemandeClinique\DepotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Handler\ReponseHandler;

/**
 * @Route("/demande-clinique/reponse")
 */
class ReponseController extends AbstractController
{
    /** @var ReponseHandler */
    private ReponseHandler $reponseHandler;

    public function __construct(ReponseHandler $reponseHandler)
    {
        $this->reponseHandler = $reponseHandler;       
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function validate(Reponse $reponse): JsonResponse
    {
        return $this->reponseHandler->validate($reponse);
    }
}
