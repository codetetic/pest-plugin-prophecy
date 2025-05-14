<?php

use function Pest\Prophecy\{autowire, argument};

class Example
{
    public function __construct(
        public DateTime $dateTime,
    ) {}
}

it('can be autowired', function (): void {
    $object = autowire(Example::class);

    expect(
        $object
    )->toBeInstanceOf(Example::class);

    expect(
        $object->dateTime
    )->toBeInstanceOf(DateTime::class);

    expect(
        argument('dateTime')
    )->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);
});
