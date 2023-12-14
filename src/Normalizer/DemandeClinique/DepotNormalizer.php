<?php

namespace App\Normalizer\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Reponse;
use DateTimeInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DepotNormalizer implements NormalizerInterface
{
    /**
     * @var ReponseNormalizer $reponseNormalizer
     */
    private $reponseNormalizer;

    public function __construct(ReponseNormalizer $reponseNormalizer)
    {
        $this->reponseNormalizer = $reponseNormalizer;
    }

    /**
     * @param $object
     * @param string|null $format
     * @param array       $context
     *
     * @return array{id: int, date_creation: DateTimeInterface, titre: string, description: string, reponse: Reponse[]}
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'date_creation' => $object->getDateCreation()->format('Y-m-d H:i:s'),
            'titre' => $object->getTitre(),
            'description' => $object->getDescription(),
            'reponses' => array_map(
                function (Reponse $reponse) {
                    return $this->reponseNormalizer->normalize($reponse);
                },
                $object->getReponses()->toArray()
            ),
        ];
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Depot;
    }
}
