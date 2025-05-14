<?php

use function Pest\Prophecy\{prophesize, exact, type, which, that, any, cetera, allOf, size};

it('can be asserted with exact()', function (): void {
    $mock = prophesize(DateTime::class);
    $mock
        ->format(exact('format'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with type()', function (): void {
    $mock = prophesize(DateTime::class);
    $mock
        ->format(type('string'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with which()', function (): void {
    $mock = prophesize(DateTime::class);
    $mock
        ->add(which('d', 1))
        ->shouldBeCalled()
        ->willReturn($mock->reveal());

    expect($mock->reveal()->add(new DateInterval('P1D')))
        ->toBe($mock->reveal());
});

it('can be asserted with that()', function (): void {
    $callback = function(string $format): bool {
        expect($format)->toBe('format');
        return $format === 'format';
    };

    $mock = prophesize(DateTime::class);
    $mock
        ->format(that($callback))
        ->shouldBeCalled()
        ->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with any()', function (): void {
    $mock = prophesize(DateTime::class);
    $mock
        ->format(any())
        ->shouldBeCalled()
        ->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with cetera()', function (): void {
    $mock = prophesize(DateTime::class);
    $mock
        ->format(cetera())
        ->shouldBeCalled()
        ->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with allOf()', function (): void {
    $mock = prophesize(DateTime::class);
    $mock
        ->format(allOf(exact('format'), type('string')))
        ->shouldBeCalled()
        ->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with size()', function (): void {
    $mock = prophesize(ArrayObject::class);
    $mock
        ->exchangeArray(size(1))
        ->shouldBeCalled()
        ->willReturn([2]);

    expect($mock->reveal()->exchangeArray([1]))
        ->toBe([2]);
});