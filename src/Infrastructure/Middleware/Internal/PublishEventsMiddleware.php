<?php

namespace Infrastructure\Middleware\Internal;

use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Infrastructure\Service\Event\EventPersister;
use Infrastructure\Service\Event\EventPublisher;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Throwable;

class PublishEventsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EventPersister         $eventPersister,
        private readonly EventPublisher         $eventPublisher,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param Envelope       $envelope
     * @param StackInterface $stack
     *
     * @return Envelope
     *
     * @throws ConnectionException
     * @throws Throwable
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $result = $stack->next()->handle($envelope, $stack);
        if (!$this->eventPersister->hasEvents()) {
            return $result;
        }
        $this->entityManager->beginTransaction();
        /*
         * save events
         */
        $this->eventPersister->store();
        try {
            /*
             * Flush all modifications
             */
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
            $this->entityManager->clear();
            // Remove doctrine cache after flush to get fresh data
            $cacheDriver = $this->entityManager->getConfiguration()->getResultCache();
            $cacheDriver?->clear();
        } catch (Throwable $exception) {
            $this->entityManager->getConnection()->rollBack();
            throw $exception;
        }

        /*
         * publish events to event bus
         */
        $this->eventPublisher->publishEvents();

        return $result;
    }
}
