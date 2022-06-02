<?php

namespace Infrastructure\Entity\Event;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Infrastructure\Entity\Timestampable;
use Infrastructure\Repository\Event\EventRepository;

/**
 * Event.
 */
#[ORM\Table(name: 'event_store', indexes: [new ORM\Index(columns: ['aggregate_id']), new ORM\Index(columns: ['event_name'])])]
#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Event
{
    use Timestampable;

    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;
    #[ORM\Column(name: 'uuid', type: 'guid', length: 36, unique: true, options: ['index' => true])]
    private string $uuid;
    #[ORM\Column(type: 'guid', length: 36, nullable: false)]
    private string $aggregateId;
    #[ORM\Column(type: 'text', nullable: false)]
    private string $payload;
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $eventName;
    #[ORM\Column(type: 'string', length: 32, nullable: false)]
    private string $version;
    #[ORM\Column(name: 'event_class', type: 'string', nullable: false)]
    private string $eventClass;
    #[ORM\Column(type: 'string', nullable: false)]
    private string $aggregateClass;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getAggregateId(): string
    {
        return $this->aggregateId;
    }

    public function setAggregateId(string $aggregateId): self
    {
        $this->aggregateId = $aggregateId;

        return $this;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function setPayload(string $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): self
    {
        $this->eventName = $eventName;

        return $this;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Gets triggered only on insert.
     */
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime('now');
        $this->updatedAt = new DateTime('now');
    }

    /**
     * Gets triggered only on update.
     */
    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTime('now');
    }

    public function getEventClass(): string
    {
        return $this->eventClass;
    }

    public function setEventClass(string $eventClass): Event
    {
        $this->eventClass = $eventClass;

        return $this;
    }

    public function getAggregateClass(): string
    {
        return $this->aggregateClass;
    }

    public function setAggregateClass(string $aggregateClass): self
    {
        $this->aggregateClass = $aggregateClass;

        return $this;
    }
}
