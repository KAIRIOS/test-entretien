<?php

namespace App\Normalizer\DemandeClinique;

use App\Entity\DemandeClinique\Reponse;
use App\Entity\DemandeClinique\ReponseValidation;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ReponseValidationNormalizer implements NormalizerInterface
{
    /**
     * @param ReponseValidation $object
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'date_creation' => $object->getDateCreation()->format('Y-m-d H:i:s'),
            'description' => $object->getDescription()
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof ReponseValidation;
    }
}