<?php

namespace App\Enum\DemandeClinique\Reponse;

class Status
{
    public const WAITING = 'waiting';
    public const VALIDATED = 'validated';

    public static function getAll(): array
    {
        return [
            self::WAITING,
            self::VALIDATED,
        ];
    }
}
