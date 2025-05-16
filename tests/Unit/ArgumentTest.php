<?php

use function Pest\Prophecy\{
    prophesize, reveal,
    allOf, approximate, any, cetera, containing, containingString, exact, in,
    is, not, notIn, size, that, type, which, withEntry, withEveryEntry, withKey,
};

class ExampleArgument
{
    public function string(string $string): string
    {
        return $string;
    }

    public function array(array $array): array
    {
        return $array;
    }

    public function object(object $object): object
    {
        return $object;
    }

    public function float(float $float): float
    {
        return $float;
    }
}

it('can be asserted with allOf()', function (): void {
    prophesize(ExampleArgument::class)
        ->string(allOf(exact('format'), type('string')))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with exact()', function (): void {
    prophesize(ExampleArgument::class)
        ->string(exact('format'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with type()', function (): void {
    prophesize(ExampleArgument::class)
        ->string(type('string'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with that()', function (): void {
    $callback = function(string $format): bool {
        expect($format)->toBe('format');
        return $format === 'format';
    };

    prophesize(ExampleArgument::class)
        ->string(that($callback))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with any()', function (): void {
    prophesize(ExampleArgument::class)
        ->string(any())
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with cetera()', function (): void {
    prophesize(ExampleArgument::class)
        ->string(cetera())
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with not()', function (): void {
    prophesize(ExampleArgument::class)
        ->string(not('result'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with containingString()', function (): void {
    prophesize(ExampleArgument::class)
        ->string(containingString('a'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with is()', function (): void {
    prophesize(ExampleArgument::class)
        ->string(is('format'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with in()', function (): void {
    prophesize(ExampleArgument::class)
        ->string(in(['format']))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with notIn()', function (): void {
    prophesize(ExampleArgument::class)
        ->string(notIn(['result']))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with size()', function (): void {
    prophesize(ExampleArgument::class)
        ->array(size(1))
        ->shouldBeCalled()
        ->willReturn([2]);

    expect(reveal(ExampleArgument::class)->array([1]))
        ->toBe([2]);
});

it('can be asserted with withEntry()', function (): void {
    prophesize(ExampleArgument::class)
        ->array(withEntry('a', 1))
        ->shouldBeCalled()
        ->willReturn([2]);

    expect(reveal(ExampleArgument::class)->array(['a' => 1]))
        ->toBe([2]);
});

it('can be asserted with withEveryEntry()', function (): void {
    prophesize(ExampleArgument::class)
        ->array(withEveryEntry(1))
        ->shouldBeCalled()
        ->willReturn([2]);

    expect(reveal(ExampleArgument::class)->array([1, 1]))
        ->toBe([2]);
});

it('can be asserted with containing()', function (): void {
    prophesize(ExampleArgument::class)
        ->array(containing(2))
        ->shouldBeCalled()
        ->willReturn([2]);

    expect(reveal(ExampleArgument::class)->array([1, 2, 3]))
        ->toBe([2]);
});

it('can be asserted with withKey()', function (): void {
    prophesize(ExampleArgument::class)
        ->array(withKey('a'))
        ->shouldBeCalled()
        ->willReturn([2]);

    expect(reveal(ExampleArgument::class)->array(['a' => 1]))
        ->toBe([2]);
});

it('can be asserted with which()', function (): void {
    prophesize(ExampleArgument::class)
        ->object(which('test1', 'test2'))
        ->shouldBeCalled()
        ->willReturn(reveal(ExampleArgument::class));

    $object = new stdClass();
    $object->test1 = 'test2';

    expect(reveal(ExampleArgument::class)->object($object))
        ->toBe(reveal(ExampleArgument::class));
});

it('can be asserted with approximate()', function (): void {
    prophesize(ExampleArgument::class)
        ->float(approximate(3.14159265359, 4))
        ->shouldBeCalled()
        ->willReturn(3.1);

    expect(reveal(ExampleArgument::class)->float(3.14159))
        ->toBe(3.1);
});
