<?php

namespace App\Event\DemandeClinique;

use App\Entity\DemandeClinique\Reponse;

class ReponseWorkflowEvent
{
    /** @var Reponse */
    private $reponse;

    /** @var string|null */
    private $transition;

    /** @var string|null */
    private $comment;

    public function __construct(Reponse $reponse, string $transition, ?string $comment)
    {
        $this->reponse = $reponse;
        $this->transition = $transition;
        $this->comment = $comment;
    }

    public function getReponse(): Reponse
    {
        return $this->reponse;
    }

    public function getTransition(): string
    {
        return $this->transition;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
