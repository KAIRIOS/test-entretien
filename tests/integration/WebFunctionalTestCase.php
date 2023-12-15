<?php

declare(strict_types=1);

namespace App\Tests\integration;

use App\Manager\DemandeClinique\ReponseManager;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class WebFunctionalTestCase extends WebTestCase
{
    protected EntityManagerInterface $entityManager;
    protected KernelBrowser $client;
    protected Router $urlGenerator;
    protected ReponseManager $reponseManager;


    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $container = static::getContainer();

        /** @var Registry $doctrine */
        $doctrine = $container->get('doctrine');

        /** @var EntityManagerInterface $manager */
        $manager = $doctrine->getManager();
        $this->entityManager = $manager;

        /** @var Router $urlGenerator */
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->urlGenerator = $urlGenerator;

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
