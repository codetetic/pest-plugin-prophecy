<?php

use function Pest\Prophecy\{prophesize, exact, type};

it('can be mocked with exact argument', function (): void {
    $mock = prophesize(DateTime::class);
    $mock->format(exact('format'))->willReturn('result');

    expect(
        $mock->reveal()->format('format')
    )->toBe('result');
});

it('can be mocked with type argument', function (): void {
    $mock = prophesize(DateTime::class);
    $mock->format(type('string'))->willReturn('result');

    expect(
        $mock->reveal()->format('format')
    )->toBe('result');
});