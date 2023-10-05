<?php

namespace App\Workflow\DemandeClinique;

use App\Entity\DemandeClinique\Reponse;
use App\Event\DemandeClinique\ReponseWorkflowEvent;
use App\Workflow\Exception\WorkflowTransitionException;
use App\Workflow\Workflow;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Workflow\Registry;

class ReponseWorkflow extends Workflow
{
    private const TRANSITION_VALIDATE = 'validate';

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(Registry $registry, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($registry);

        $this->eventDispatcher = $eventDispatcher;
    }

    public function validate(Reponse $reponse, ?string $comment): void
    {
        try {
            $this->applyTransition($reponse, self::TRANSITION_VALIDATE);
        } catch (WorkflowTransitionException $e) {
            return;
        }

        $this->eventDispatcher->dispatch(
            new ReponseWorkflowEvent($reponse, self::TRANSITION_VALIDATE, $comment),
            ReponseWorkflowEvent::class
        );
    }

    /**
     * @param Reponse[] $reponses
     */
    public function validateMany(iterable $reponses, ?string $comment): void
    {
        foreach ($reponses as $reponse) {
            $this->validate($reponse, $comment);
        }
    }
}
