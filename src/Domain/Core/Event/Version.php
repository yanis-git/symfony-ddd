<?php

namespace Domain\Core\Event;

use InvalidArgumentException;

class Version
{
    public const DEFAULT_VERSION = '1.0';

    final public function __construct(private readonly string $version)
    {
        $this->assertVersion();
    }

    public function __toString(): string
    {
        return $this->version;
    }

    public static function default(): static
    {
        return new static(static::DEFAULT_VERSION);
    }

    protected function assertVersion(): void
    {
        if (!preg_match('/\d+\.\d+/', $this->version)) {
            throw new InvalidArgumentException('Version format is not valid');
        }
    }

    public function isEqual(Version $version): bool
    {
        return $this->version === $version->version;
    }
}
