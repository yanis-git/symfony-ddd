<?php

namespace Infrastructure\Transformer\Event;

use Domain\Core\Contract\DomainEventInterface;
use Infrastructure\Entity\Event\Event;
use Infrastructure\Service\Serializer\JsonSerializer;

class EventTransformer
{
    public function __construct(private readonly JsonSerializer $serializer)
    {
    }

    public function fromDomain(DomainEventInterface $event, ?string $userUuid): Event
    {
        return (new Event())
            ->setAggregateClass($event->getAggregateClassName())
            ->setEventClass($event->getEventClass())
            ->setUuid($event->getEventId())
            ->setAggregateId($event->getAggregateId())
            ->setEventName($event->getEventName())
            ->setPayload($this->serializer->serialize($event))
            ->setVersion($event->getVersion())
            ->setUserUuid($userUuid);
    }


    public function toDomain(Event $event): DomainEventInterface
    {
        return $this->serializer->deserialize($event->getPayload(), $event->getEventClass());
    }
}
