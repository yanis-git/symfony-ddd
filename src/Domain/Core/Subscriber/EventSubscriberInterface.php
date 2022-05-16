<?php

namespace Domain\Core\Subscriber;

use Domain\Core\Event\DomainEvent;

interface EventSubscriberInterface
{
    public function handle(DomainEvent $domainEvent): void;
}
