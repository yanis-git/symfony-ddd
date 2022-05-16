<?php

namespace Infrastructure\Middleware\Event;

use Infrastructure\Service\Event\EventLogger;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class EventLoggerMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly EventLogger $logger)
    {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $this->logger->logEvent($envelope->getMessage());

        return $stack->next()->handle($envelope, $stack);
    }
}
