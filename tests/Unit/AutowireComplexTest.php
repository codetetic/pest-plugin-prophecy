<?php

use function Pest\Prophecy\argument;
use function Pest\Prophecy\autowire;

enum ExampleComplexEnum: string
{
    case TEST = 'test';
}

class ExampleComplex
{
    public function __construct(
        public DateTime $dateTime,
        public DateTime|DateTimeImmutable $dateTimeUnion,
        public DateTime&DateTimeInterface $dateTimeIntersection,
        public string $string,
        public int $int,
        public float $float,
        public bool $bool,
        public array $array,
        public ExampleComplexEnum $enum,
        public string $default = 'default',
        public DateTime $defaultDateTime = new DateTime('2000-01-01 00:00:00'),
    ) {
    }
}

it('can be a complex autowire', function (): void {
    $object = autowire(
        ExampleComplex::class,
        [
            'dateTimeUnion' => new DateTime('2000-01-02 00:00:00'),
            'dateTimeIntersection' => new DateTime('2000-01-03 00:00:00'),
            'string' => 'string',
            'int' => 1,
            'float' => 1.1,
            'bool' => true,
            'array' => [1, 2, 3],
            'enum' => ExampleComplexEnum::TEST,
        ],
    );

    argument('dateTime')
        ->format(DateTimeInterface::ATOM)
        ->shouldBeCalled()
        ->willReturn('formatted1');

    argument('defaultDateTime')
        ->format(DateTimeInterface::ATOM)
        ->shouldBeCalled()
        ->willReturn('formatted2');

    expect(
        [
            'dateTime' => $object->dateTime->format(DateTimeInterface::ATOM),
            'dateTimeUnion' => $object->dateTimeUnion,
            'dateTimeIntersection' => $object->dateTimeIntersection,
            'string' => $object->string,
            'int' => $object->int,
            'float' => $object->float,
            'bool' => $object->bool,
            'array' => $object->array,
            'enum' => $object->enum->value,
            'default' => $object->default,
            'defaultDateTime' => $object->defaultDateTime->format(DateTimeInterface::ATOM),
    ])->toMatchSnapshot();

    expect(
        [
            'dateTime' => argument('dateTime')::class,
            'dateTimeUnion' => argument('dateTimeUnion'),
            'dateTimeIntersection' => argument('dateTimeIntersection'),
            'string' => argument('string'),
            'int' => argument('int'),
            'float' => argument('float'),
            'bool' => argument('bool'),
            'array' => argument('array'),
            'enum' => argument('enum'),
            'default' => argument('default'),
            'defaultDateTime' => argument('defaultDateTime')::class,
        ],
    )->toMatchSnapshot();
});
