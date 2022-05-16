<?php

namespace Domain\Core\Event;

use DateTimeImmutable;
use Domain\Core\Contract\DomainEventInterface;
use Exception;

abstract class DomainEventAbstract implements DomainEventInterface
{
    public const API_VERSION = '1.0';

    protected EventId $eventId;

    protected string $version;

    protected string $eventName;

    /**
     * @var string
     */
    protected $eventClass;

    protected DateTimeImmutable $createdAt;

    /**
     * DomainEventAbstract constructor.
     *
     * @throws Exception
     */
    public function __construct(string $eventName = '')
    {
        $this->eventId = EventId::generate();
        $this->eventName = $this->generateEventName($eventName);
        $this->eventClass = $this::class;
        $this->createdAt = new DateTimeImmutable();
        $this->version = self::API_VERSION;
    }

    private function generateEventName(string $eventName): string
    {
        if (empty($eventName)) {
            return self::getShortClassName($this::class);
        }

        return $eventName;
    }

    /**
     * Copy from Symfony maker str.
     *
     * @param $fullClassName
     */
    public static function getShortClassName($fullClassName): string
    {
        if (empty(self::getNamespace($fullClassName))) {
            return $fullClassName;
        }

        return substr($fullClassName, strrpos($fullClassName, '\\') + 1);
    }

    /**
     * Copy from Symfony maker str.
     */
    public static function getNamespace(string $fullClassName): string
    {
        return substr($fullClassName, 0, strrpos($fullClassName, '\\'));
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getEventClass(): string
    {
        return $this->eventClass;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
