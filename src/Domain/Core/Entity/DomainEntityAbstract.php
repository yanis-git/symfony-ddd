<?php

namespace Domain\Core\Entity;

use Domain\Core\Contract\DomainEntityInterface;
use Domain\Core\Contract\EntityIdInterface;
use JsonSerializable;

abstract class DomainEntityAbstract implements DomainEntityInterface, JsonSerializable
{
    protected function __construct(protected EntityIdInterface $uuid)
    {
    }

    public function getUuid(): EntityIdInterface
    {
        return $this->uuid;
    }

    public function jsonSerialize(): array
    {
        return array_merge(
            [
                'uuid' => (string) $this->uuid,
            ],
            $this->jsonData()
        );
    }

    /**
     * Return all jsonSerializable data.
     * For ex.
     *
     * return [
     *  'title' => $this->getTitle()
     * ];
     */
    abstract public function jsonData(): array;

    public function __toString(): string
    {
        return (string) $this->uuid;
    }
}
