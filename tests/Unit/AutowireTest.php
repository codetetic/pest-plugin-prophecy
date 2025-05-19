<?php

use function Pest\Prophecy\argument;
use function Pest\Prophecy\autowire;

class Example
{
    public function __construct(
        public stdClass $object,
    ) {
    }
}

it('can be autowired', function (): void {
    $object = autowire(Example::class);

    expect($object)
        ->toBeInstanceOf(Example::class);

    expect($object->object)
        ->toBeInstanceOf(stdClass::class);

    expect(argument('object'))
        ->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);
});
