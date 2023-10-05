<?php

declare(strict_types=1);

namespace App\Workflow;

use App\Workflow\Exception\WorkflowTransitionException;
use Symfony\Component\Workflow\Registry;

class Workflow
{
    /** @var Registry */
    private $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    protected function applyTransition(object $subject, string $transition): void
    {
        $workflow = $this->registry->get($subject);

        if (false === $workflow->can($subject, $transition)) {
            throw new WorkflowTransitionException();
        }

        $workflow->apply($subject, $transition);
    }
}
