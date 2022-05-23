<?php

use Domain\Core\Event\Version;

dataset('versions', [
    '1.0',
    '2.0',
    '2.1',
    '10.0',
    '42.42'
]);

dataset('invalid_versions', [
    'something',
    '10',
    '.1',
    '10.b'
]);

it('should be castable to string', fn() => expect((string)Version::default())->toBeString());

it('should have default version', fn() => expect((string) Version::default())->toBe('1.0'));

it('should be overridable', fn(string $version) => expect((string) (new Version($version)))->toBe($version))
    ->with('versions')
;

it('should throw exception when format is invalid', fn(string $version) => new Version($version))
    ->throws(InvalidArgumentException::class)
    ->with('invalid_versions')
;

it('should be comparable', function () {
    $v1 = new Version('1.0');
    $v2 = new Version('2.0');
    $v2bis = new Version('2.0');
    expect($v1->isEqual($v2))->toBeFalse();
    expect($v2bis->isEqual($v2))->toBeTrue();
});
