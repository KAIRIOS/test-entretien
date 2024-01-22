<?php

namespace App\Api\v1\Controller\DemandeClinique;

use App\Manager\DemandeClinique\ReponseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/demande-clinique/reponse")
 */
class ReponseController extends AbstractController
{

    /**
     * @Route("/validate-batch", name="reponse_validate_batch", methods={"PATCH"})
     */
    public function validate_batch(Request $request, ReponseManager $manager): Response
    {
        // In a real setting: validate query
        // Just replicating existing behavior from DepotController here

        $data = json_decode($request->getContent(), true);

        $manager->validateBatch($data['ids'], $data['reason']);

        return $this->json(["result" => "ok"]);
    }
}
