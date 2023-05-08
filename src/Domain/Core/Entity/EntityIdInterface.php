<?php

namespace Domain\Core\Entity;

interface EntityIdInterface
{
    public static function fromString(string $id): static;

    public static function generate(): static;

    public function equals(EntityIdInterface $other): static;

    public function __toString(): string;
}
