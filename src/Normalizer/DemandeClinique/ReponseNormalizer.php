<?php

namespace App\Normalizer\DemandeClinique;

use App\Entity\DemandeClinique\Reponse;
use App\Entity\DemandeClinique\Validation;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ReponseNormalizer implements NormalizerInterface
{

    /** @var ValidationNormalizer $validationNormalizer */
    private $validationNormalizer;

    public function __construct(ValidationNormalizer $validationNormalizer)
    {
        $this->validationNormalizer = $validationNormalizer;
    }
    public function normalize($object, string $format = null, array $context = [])
    {

        return [
            'id' => $object->getId(),
            'date_creation' => $object->getDateCreation()->format('Y-m-d H:i:s'),
            'titre' => $object->getTitre(),
            'description' => $object->getDescription(),
            'depot' => $object->getDepot()->getId(),
            'type' => $object->getType(),
            'validation' => $this->validationNormalize($object),
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Reponse;
    }

    public function validationNormalize($object){
        return $object->getValidation() !== null ? $this->validationNormalizer->normalize($object->getValidation()): null;
    }
}
