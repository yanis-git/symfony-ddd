<?php

namespace Domain\Core\Contract;

interface EntityIdInterface
{
    public static function fromString(string $id): static;

    public static function generate(): static;

    public function equals(EntityIdInterface $other): bool;

    public function __toString(): string;
}
