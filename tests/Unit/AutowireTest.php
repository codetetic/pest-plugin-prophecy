<?php

use function Pest\Prophecy\argument;
use function Pest\Prophecy\autowire;
use function Pest\Prophecy\exact;

class ExampleAutowire
{
    public function __construct(
        public string $string,
    ) {
    }

    public function string(string $string): string
    {
        return $string;
    }
}

final class ExampleAutowireWrapper
{
    public function __construct(
        public ExampleAutowire $object,
    ) {
    }

    public function string(string $string): string
    {
        return $this->object->string($string);
    }
}

it('can be autowired', function (): void {
    $object = autowire(ExampleAutowireWrapper::class);

    expect(argument('object'))
        ->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);

    argument('object')
        ->string(exact('format'))
        ->shouldBeCalled()
        ->willReturn('result');

    expect($object)
        ->toBeInstanceOf(ExampleAutowireWrapper::class);

    expect($object->object)
        ->toBeInstanceOf(ExampleAutowire::class);

    expect($object->string('format'))
        ->toBe('result');
});
