<?php

namespace App\Normalizer\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use DateTimeInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\DemandeClinique\Reponse;

class ReponseNormalizer implements NormalizerInterface
{
    /**
     * @param $object
     * @param string|null $format
     * @param array       $context
     *
     * @return array{id: int, date_creation: DateTimeInterface, titre: string, description: string, depot: Depot, type: int, validation_raison: string}
     * */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'date_creation' => $object->getDateCreation()->format('Y-m-d H:i:s'),
            'titre' => $object->getTitre(),
            'description' => $object->getDescription(),
            'depot' => $object->getDepot()->getId(),
            'type' => $object->getType(),
            'est_validee' => $object->estValidee(),
            'validation_raison' => $object->getRaisonValidation(),
        ];
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Reponse;
    }
}
