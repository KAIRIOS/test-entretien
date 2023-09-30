<?php

namespace App\Normalizer\DemandeClinique;

use App\Entity\DemandeClinique\Validation;
use App\Normalizer\DemandeClinique\ReponseNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ValidationNormalizer implements NormalizerInterface
{
	public function normalize($object, string $format = null, array $context = [])
	{
		return [
			'id' => $object->getId(),
			'date_creation' => $object->getDateCreation()->format('Y-m-d H:i:s'),
			'raison' => $object->getRaison(),
			'reponse' =>$object->getReponse()->getId(),
			'depot' => $object->getDepot()->getId(),
		];
	}

	public function supportsNormalization($data, string $format = null)
	{
		return $data instanceof Validation;
	}
}
