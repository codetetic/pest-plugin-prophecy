<?php

use function Pest\Prophecy\{prophesize, reveal};

it('can be accessed as function', function (): void {
    expect(prophesize(stdClass::class))
        ->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);

    expect(reveal(stdClass::class))
        ->toBeInstanceOf(stdClass::class);
});