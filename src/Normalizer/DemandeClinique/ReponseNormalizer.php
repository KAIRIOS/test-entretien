<?php

namespace App\Normalizer\DemandeClinique;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\DemandeClinique\Reponse;

class ReponseNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        // Changes here are optional but future-proof
        // Would require test changes too
        return [
            'id' => $object->getId(),
            'date_creation' => $object->getDateCreation()->format('Y-m-d H:i:s'),
//            'date_validation' => $object->getDateValidated() ? $object->getDateValidated()->format('Y-m-d H:i:s') : null,
//            'validation_comment' => $object->getValidationComment(),
            'titre' => $object->getTitre(),
            'description' => $object->getDescription(),
            'depot' => $object->getDepot()->getId(),
            'type' => $object->getType(),
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Reponse;
    }
}