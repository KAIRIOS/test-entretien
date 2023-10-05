<?php

namespace App\Subscriber\DemandeClinique;

use App\Event\DemandeClinique\ReponseWorkflowEvent;
use App\Factory\DemandeClinique\ReponseWorkflowLogFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ReponseWorkflowSubscriber implements EventSubscriberInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ReponseWorkflowLogFactory */
    private $logFactory;

    public function __construct(EntityManagerInterface $em, ReponseWorkflowLogFactory $logFactory)
    {
        $this->em = $em;
        $this->logFactory = $logFactory;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ReponseWorkflowEvent::class => 'onTransition',
        ];
    }

    public function onTransition(ReponseWorkflowEvent $event): void
    {
        $log = $this->logFactory->create(
            $event->getReponse(),
            $event->getTransition(),
            $event->getComment()
        );

        $this->em->persist($log);
        $this->em->flush();
    }
}
