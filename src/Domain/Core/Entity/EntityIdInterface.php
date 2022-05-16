<?php

namespace Domain\Core\Entity;

interface EntityIdInterface
{
    public static function fromString(string $id);

    public static function generate();

    public function equals(EntityIdInterface $other);

    public function __toString();
}
