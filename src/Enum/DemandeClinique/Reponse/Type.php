<?php

namespace App\Enum\DemandeClinique\Reponse;

class Type
{
    public const PRIORITAIRE = 1;
    public const DANS_L_HEURE = 2;
    public const DANS_LA_JOURNEE = 3;
    public const DANS_LES_48_HEURES = 4;

    /**
     * @return int[]
     */
    public static function getAll(): array
    {
        return [
            self::PRIORITAIRE,
            self::DANS_L_HEURE,
            self::DANS_LA_JOURNEE,
            self::DANS_LES_48_HEURES,
        ];
    }
}
