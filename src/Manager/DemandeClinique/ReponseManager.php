<?php

namespace App\Manager\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Reponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Factory\DemandeClinique\ReponseFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReponseManager
{
    private ValidatorInterface $validator;

    protected EntityManagerInterface $entityManager;

    protected EntityRepository $repository;

    public function __construct(ReponseFactory $reponseFactory, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->reponseFactory = $reponseFactory;
        $this->validator = $validator;
    }

    public function getEntityClass(): string
    {
        return Reponse::class;
    }

    public function creer(Depot $depot, string $titre, string $description, int $type): Reponse
    {
        $reponse = $this->reponseFactory->creer($depot, $titre, $description, $type);

        $errors = $this->validator->validate($reponse);

        if (count($errors) > 0) {
            throw new UnprocessableEntityHttpException((string) $errors);           
        }
        
        $this->save($reponse);
        
        return $reponse;
    }

    public function save(Reponse $reponse): void 
    {
        $this->entityManager->persist($reponse);
        $this->entityManager->flush();
    }
}
