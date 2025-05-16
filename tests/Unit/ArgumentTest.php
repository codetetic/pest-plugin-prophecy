<?php

use function Pest\Prophecy\{
    prophesize, reveal, exact, allOf,
    type, which, that, any, cetera, not, is, in, notIn,
    size, withEntry, withEveryEntry, containing, withKey,
    containingString, approximate,
};

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

it('can be asserted with withEntry()', function (): void {
    prophesize(ArrayObject::class)
        ->exchangeArray(withEntry('a', 1))
        ->shouldBeCalled()
        ->willReturn([2]);

    expect(reveal()->exchangeArray(['a' => 1]))
        ->toBe([2]);
});

it('can be asserted with withEveryEntry()', function (): void {
    prophesize(ArrayObject::class)
        ->exchangeArray(withEveryEntry(1))
        ->shouldBeCalled()
        ->willReturn([2]);

    expect(reveal()->exchangeArray([1, 1]))
        ->toBe([2]);
});

it('can be asserted with containing()', function (): void {
    prophesize(ArrayObject::class)
        ->exchangeArray(containing(2))
        ->shouldBeCalled()
        ->willReturn([2]);

    expect(reveal()->exchangeArray([1, 2, 3]))
        ->toBe([2]);
});

it('can be asserted with withKey()', function (): void {
    prophesize(ArrayObject::class)
        ->exchangeArray(withKey('a'))
        ->shouldBeCalled()
        ->willReturn([2]);

    expect(reveal()->exchangeArray(['a' => 1]))
        ->toBe([2]);
});

it('can be asserted with not()', function (): void {
    prophesize(DateTime::class)
        ->format(not('result'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with containingString()', function (): void {
    prophesize(DateTime::class)
        ->format(containingString('a'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with is()', function (): void {
    prophesize(DateTime::class)
        ->format(is('format'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with approximate()', function (): void {
    prophesize(NumberFormatter::class)
        ->format(approximate(3.14159265359, 4))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format(3.14159))
        ->toBe('result');
});

it('can be asserted with in()', function (): void {
    prophesize(DateTime::class)
        ->format(in(['format']))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format('format'))
        ->toBe('result');
});

it('can be asserted with notIn()', function (): void {
    prophesize(DateTime::class)
        ->format(notIn(['result']))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal()->format('format'))
        ->toBe('result');
});