<?php

use function Pest\Prophecy\prophesize;
use function Pest\Prophecy\reveal;

class Example
{
}

it('can be accessed as a function', function (): void {
    $prophecy = prophesize(Example::class);

    expect($prophecy)
        ->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);

    expect($prophecy->reveal())
        ->toBeInstanceOf(Example::class);
});

it('can be accessed as a function and use reveal helper', function (): void {
    expect(prophesize(Example::class))
        ->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);

    expect(reveal(Example::class))
        ->toBeInstanceOf(Example::class);
});
