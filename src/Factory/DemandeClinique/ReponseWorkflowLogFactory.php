<?php

namespace App\Factory\DemandeClinique;

use App\Entity\DemandeClinique\Reponse;
use App\Entity\DemandeClinique\ReponseWorkflowLog;

class ReponseWorkflowLogFactory
{
    public function create(Reponse $reponse, string $transition, ?string $comment): ReponseWorkflowLog
    {
        return (new ReponseWorkflowLog())
            ->setReponse($reponse)
            ->setTransition($transition)
            ->setComment($comment)
            ->setCreatedAt(new \DateTime())
        ;
    }
}
