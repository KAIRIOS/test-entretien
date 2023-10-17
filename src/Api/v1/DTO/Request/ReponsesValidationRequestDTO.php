<?php

namespace App\Api\v1\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class ReponsesValidationRequestDTO
{
    /**
     * @Assert\NotBlank()
     */
    public string $validationReason;

    /**
     * @var int[]
     * @Assert\NotBlank()
     */
    public array $reponsesIds;
}
