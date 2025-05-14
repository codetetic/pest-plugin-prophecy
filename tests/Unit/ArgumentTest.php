<?php

use function Pest\Prophecy\{prophesize, exact, type, which, that, any};

it('can be asserted with exact()', function (): void {
    $mock = prophesize(DateTime::class);

    $mock
        ->format(exact('format'))
        ->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with type()', function (): void {
    $mock = prophesize(DateTime::class);

    $mock
        ->format(type('string'))
        ->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with which()', function (): void {
    $mock = prophesize(DateTime::class);

    $mock
        ->add(which('d', 1))
        ->willReturn($mock->reveal());

    expect($mock->reveal()->add(new DateInterval('P1D')))
        ->toBe($mock->reveal());
});

it('can be asserted with that()', function (): void {
    $mock = prophesize(DateTime::class);

    $mock
        ->format(
            that(function(string $format): bool {
                expect($format)->toBe('format');
                return $format === 'format';
            }))
        ->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with any()', function (): void {
    $mock = prophesize(DateTime::class);

    $mock
        ->format(any())
        ->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});