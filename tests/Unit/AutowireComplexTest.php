<?php

use function Pest\Prophecy\argument;
use function Pest\Prophecy\autowire;

class ExampleComplexValue implements ExampleComplexValueInterface
{
    public function __construct(
        public string $value,
    ) {
    }

    public function value(): string
    {
        return $this->value;
    }
}

class ExampleComplexValueImmutable
{
}

interface ExampleComplexValueInterface
{
}

enum ExampleComplexEnum: string
{
    case TEST = 'test';
}

class ExampleComplex
{
    public function __construct(
        public ExampleComplexValue $value,
        public ExampleComplexValue|ExampleComplexValueImmutable $valueUnion,
        public ExampleComplexValue&ExampleComplexValueInterface $valueIntersection,
        public string $string,
        public int $int,
        public float $float,
        public bool $bool,
        public array $array,
        public ExampleComplexEnum $enum,
        public string $default = 'default',
        public ExampleComplexValue $defaultValue = new ExampleComplexValue('value1'),
    ) {
    }
}

it('can be a complex autowire', function (): void {
    $object = autowire(
        ExampleComplex::class,
        [
            'valueUnion' => new ExampleComplexValue('value2'),
            'valueIntersection' => new ExampleComplexValue('value2'),
            'string' => 'string',
            'int' => 1,
            'float' => 1.1,
            'bool' => true,
            'array' => [1, 2, 3],
            'enum' => ExampleComplexEnum::TEST,
        ],
    );

    argument('value')
        ->value()
        ->shouldBeCalled()
        ->willReturn('formatted1');

    argument('defaultValue')
        ->value()
        ->shouldBeCalled()
        ->willReturn('formatted2');

    expect(
        [
            'value' => $object->value->value(),
            'valueUnion' => $object->valueUnion,
            'valueIntersection' => $object->valueIntersection,
            'string' => $object->string,
            'int' => $object->int,
            'float' => $object->float,
            'bool' => $object->bool,
            'array' => $object->array,
            'enum' => $object->enum->value,
            'default' => $object->default,
            'defaultvalue' => $object->defaultValue->value(),
        ])->toMatchSnapshot();

    expect(
        [
            'value' => argument('value')::class,
            'valueUnion' => argument('valueUnion'),
            'valueIntersection' => argument('valueIntersection'),
            'string' => argument('string'),
            'int' => argument('int'),
            'float' => argument('float'),
            'bool' => argument('bool'),
            'array' => argument('array'),
            'enum' => argument('enum'),
            'default' => argument('default'),
            'defaultvalue' => argument('defaultValue')::class,
        ],
    )->toMatchSnapshot();
});
