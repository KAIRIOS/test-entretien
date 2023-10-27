<?php

namespace App\Dao;

class CreerReponseValidation
{
    /**
     * @var int[]
     */
    public $idReponses = [];

    /**
     * @var string
     */
    public $description = '';

    // Obligé de faire un denormalizer à la main, mais intégré dans les autres version SF
    public static function denormalizer(array $object): self {
        $creerReponseValidation = new self();

        $creerReponseValidation->idReponses = $object['idReponses'];
        $creerReponseValidation->description = $object['description'];

        return $creerReponseValidation;
    }
}