<?php

use function Pest\Prophecy\{prophesize, reveal};

it('can be accessed as function', function (): void {
    expect(prophesize(DateTime::class))
        ->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);

    expect(reveal())
        ->toBeInstanceOf(DateTime::class);
});