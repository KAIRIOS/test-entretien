<?php

declare(strict_types=1);

namespace App\Tests\integration;

use App\Manager\DemandeClinique\ReponseManager;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class FunctionalTestCase extends KernelTestCase
{
    protected EntityManagerInterface $entityManager;
    protected ReponseManager $reponseManager;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

    /** @var Registry $doctrine */
        $doctrine = $container->get('doctrine');

    /** @var EntityManagerInterface $manager */
        $manager = $doctrine->getManager();
        $this->entityManager = $manager ;

        /** @var ReponseManager $reponseManager */
        $reponseManager = $container->get(ReponseManager::class);

        $this->reponseManager = $reponseManager;

    }

    /**
     * @inheritDoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        unset($this->entityManager);
    }
}
