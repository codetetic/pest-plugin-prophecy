<?php

use function Pest\Prophecy\{prophesize};

it('can be accessed as function', function (): void {
    expect(
        prophesize(DateTime::class)
    )->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);
});