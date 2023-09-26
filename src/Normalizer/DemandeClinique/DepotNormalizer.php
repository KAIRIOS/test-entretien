<?php

namespace App\Normalizer\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Reponse;
use App\Normalizer\DemandeClinique\ReponseNormalizer;
use App\Normalizer\DemandeClinique\ValidationNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DepotNormalizer implements NormalizerInterface
{
    /** @var ReponseNormalizer $reponseNormalizer */
    private $reponseNormalizer;

    /** @var ValidationNormalizer $validationNormalizer */
    private $validationNormalizer;

    public function __construct(ReponseNormalizer $reponseNormalizer, ValidationNormalizer $validationNormalizer)
    {
        $this->reponseNormalizer = $reponseNormalizer;
        $this->validationNormalizer = $validationNormalizer;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $validation = $object->getValidation() ? $this->validationNormalizer->normalize($object->getValidation()) : null;

        return [
            'id' => $object->getId(),
            'date_creation' => $object->getDateCreation()->format('Y-m-d H:i:s'),
            'titre' => $object->getTitre(),
            'description' => $object->getDescription(),
            'reponses' => array_map(function (Reponse $reponse) {
                return $this->reponseNormalizer->normalize($reponse);
            }, $object->getReponses()->toArray()),
            'validation' => $validation,
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Depot;
    }
}
