<?php

namespace Infrastructure\Middleware\Event;

use Domain\Core\Contract\DomainEventInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class EventLoggerMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if ($envelope->getMessage() instanceof DomainEventInterface) {
            /** @var DomainEventInterface $event */
            $event = $envelope->getMessage();
            $this->logEvent($event);
        }
        return $stack->next()->handle($envelope, $stack);
    }

    public function logEvent(DomainEventInterface $event): void
    {
        $this->logger->info(
            sprintf('Event for %s dispatched to the bus', $event->getAggregateClassName()),
            [
                'aggregateName' => $event->getAggregateClassName(),
                'aggregateId' => (string)$event->getAggregateId(),
                'version' => $event->getVersion(),
                'name' => $event->getEventName(),
            ]
        );
    }
}
