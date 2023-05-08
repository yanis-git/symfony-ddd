<?php

namespace Domain\Core\Event;

use DateTimeImmutable;
use Domain\Core\Contract\DomainEventInterface;
use Exception;

abstract class DomainEventAbstract implements DomainEventInterface
{
    protected EventId $eventId;
    protected Version $version;
    protected string $eventName;
    protected string $eventClass;
    protected DateTimeImmutable $createdAt;

    /**
     * @throws Exception
     */
    public function __construct(string $eventName = '')
    {
        $this->eventId = EventId::generate();
        $this->eventName = $this->generateEventName($eventName);
        $this->eventClass = $this::class;
        $this->createdAt = new DateTimeImmutable();
        $this->version = Version::default();
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
     * @param string $fullClassName
     * @return string
     */
    public static function getShortClassName(string $fullClassName): string
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
        $pos = strrpos($fullClassName, '\\');
        return substr($fullClassName, 0, $pos !== false ? $pos : null);
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getVersion(): Version
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
