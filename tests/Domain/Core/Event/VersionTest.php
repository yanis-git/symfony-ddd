<?php

namespace App\Tests\Domain\Core\Event;

use Domain\Core\Event\Version;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{

    #[Test]
    public function it_should_be_castable_to_string(): void
    {
        expect((string)Version::default())->toBeString();
    }

    #[Test]
    public function is_should_have_default_version(): void
    {
        expect((string)Version::default())->toBe('1.0');
    }

    #[Test]
    #[DataProvider('validVersionProvider')]
    public function it_should_be_overridable(string $version): void
    {
        expect((string) (new Version($version)))->toBe($version);
    }

    #[Test]
    #[DataProvider('invalidVersionProvider')]
    public function it_should_throw_exception_when_format_is_invalid(string $version): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Version format is not valid');
        new Version($version);
    }

    public static function validVersionProvider(): array
    {
        return [
            ['1.0'],
            ['2.0'],
            ['2.1'],
            ['10.0'],
            ['42.42']
        ];
    }

    public static function invalidVersionProvider(): array
    {
        return [
            ['something'],
            ['10'],
            ['.1'],
            ['10.b']
        ];
    }
}