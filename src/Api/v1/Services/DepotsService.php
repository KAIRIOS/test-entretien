<?php

namespace App\Api\v1\Services;

use App\Api\v1\DTO\Request\ReponsesValidationRequestDTO;
use App\Api\v1\DTO\Request\ReponseValidationRequestDTO;
use App\Api\v1\DTO\Response\ReponseValidationResponseDTO;
use App\Api\v1\Exceptions\ReponseNotFountException;
use App\Entity\DemandeClinique\Reponse;
use Doctrine\ORM\EntityManagerInterface;

class DepotsService
{
    private const FORMAT = 'Y-m-d H:i:s';
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ReponsesValidationRequestDTO $reponsesValidationRequestDTO
     * @return ReponseValidationResponseDTO[]
     * @throws ReponseNotFountException
     */
    public function validateReponses(ReponsesValidationRequestDTO $reponsesValidationRequestDTO): array
    {
        $reponses = $this->entityManager->getRepository(Reponse::class)->findBy(['id' => $reponsesValidationRequestDTO->reponsesIds]);

        if (count($reponses) === 0) {
            throw new ReponseNotFountException(sprintf("No 'Reponse' was found for the provided IDs: [%s]", implode(', ', $reponsesValidationRequestDTO->reponsesIds)));
        }

        foreach ($reponses as $reponse) {
            $reponse->setValidationReason($reponsesValidationRequestDTO->validationReason);
            $reponse->setValidatedAt(new \DateTime());
        }

        $this->entityManager->flush();

        return $this->buildReponsesValidationDto($reponses);
    }

    /**
     * @param array $reponses
     * @return ReponseValidationResponseDTO[]
     */
    private function buildReponsesValidationDto(array $reponses): array
    {
        $results = [];
        foreach ($reponses as $reponse) {
            $reponseValidationResponseDTO = new ReponseValidationResponseDTO();
            $reponseValidationResponseDTO->validationReason = $reponse->getValidationReason();
            $reponseValidationResponseDTO->validatedAt = $reponse->getValidatedAt()->format(self::FORMAT);
            $results[] = $reponseValidationResponseDTO;
        }

        return $results;
    }
}