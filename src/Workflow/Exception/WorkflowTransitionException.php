<?php

declare(strict_types=1);

namespace App\Workflow\Exception;

class WorkflowTransitionException extends \Exception
{
    public const MESSAGE = 'La transition a échoué.';

    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? self::MESSAGE);
    }
}
