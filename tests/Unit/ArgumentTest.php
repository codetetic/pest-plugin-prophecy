<?php

use function Pest\Prophecy\{prophesize, reveal, exact, type, which, that, any, cetera, allOf, size};

it('can be asserted with exact()', function (): void {
    prophesize(DateTime::class)
        ->format(exact('format'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with type()', function (): void {
    prophesize(DateTime::class)
        ->format(type('string'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with which()', function (): void {
    prophesize(DateTime::class)
        ->add(which('d', 1))
        ->shouldBeCalled()
        ->willReturn(reveal());

    expect(reveal()->add(new DateInterval('P1D')))
        ->toBe(reveal());
});

it('can be asserted with that()', function (): void {
    $callback = function(string $format): bool {
        expect($format)->toBe('format');
        return $format === 'format';
    };

    prophesize(DateTime::class)
        ->format(that($callback))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with any()', function (): void {
    prophesize(DateTime::class)
        ->format(any())
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with cetera()', function (): void {
    prophesize(DateTime::class)
        ->format(cetera())
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with allOf()', function (): void {
    prophesize(DateTime::class)
        ->format(allOf(exact('format'), type('string')))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with size()', function (): void {
    prophesize(ArrayObject::class)
        ->exchangeArray(size(1))
        ->shouldBeCalled()
        ->willReturn([2]);

    expect(reveal()->exchangeArray([1]))
        ->toBe([2]);
});