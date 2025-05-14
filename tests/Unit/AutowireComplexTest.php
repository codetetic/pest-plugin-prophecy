<?php

use function Pest\Prophecy\{autowire, argument};

enum ExampleComplexEnum: string
{
    case TEST = 'test';
}

class ExampleComplex implements JsonSerializable
{
    public function __construct(
        public DateTime $dateTime,
        public DateTime $dateTimeWithDefault = new DateTime('2000-01-01 00:00:00'),
        public DateTime|DateTimeImmutable $dateTimeUnion,
        public DateTime&DateTimeInterface $dateTimeIntersection,
        public string $string,
        public int $int,
        public float $float,
        public bool $bool,
        public array $array,
        public ExampleComplexEnum $enum,
        public string $default = 'default',
    ) {}

    public function jsonSerialize(): mixed
    {
        return [
            'dateTime' => $this->dateTime->format(DateTimeInterface::ATOM),
            'dateTimeWithDefault' => $this->dateTimeWithDefault->format(DateTimeInterface::ATOM),
            'dateTimeUnion' => $this->dateTimeUnion,
            'dateTimeIntersection' => $this->dateTimeIntersection,
            'string' => $this->string,
            'int' => $this->int,
            'float' => $this->float,
            'bool' => $this->bool,
            'array' => $this->array,
            'enum' => $this->enum->value,
            'default' => $this->default,
        ];
    }
}

dataset('mock', [
    fn() => autowire(
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
    ),
]);

it('can be a complex autowire', function (ExampleComplex $object): void {
    $mock = argument('dateTime');
    $mock->format(DateTimeInterface::ATOM)->willReturn('formatted1');

    $mock = argument('dateTimeWithDefault');
    $mock->format(DateTimeInterface::ATOM)->willReturn('formatted2');

    expect(
        $object
    )->toMatchSnapshot();
})->with('mock');

it('can access all arguments from complex autowire', function (ExampleComplex $object): void {
    expect(
        [
            'dateTime' => get_class(argument('dateTime')),
            'dateTimeWithDefault' => get_class(argument('dateTimeWithDefault')),
            'dateTimeUnion' => argument('dateTimeUnion'),
            'dateTimeIntersection' => argument('dateTimeIntersection'),
            'string' => argument('string'),
            'int' => argument('int'),
            'float' => argument('float'),
            'bool' => argument('bool'),
            'array' => argument('array'),
            'enum' => argument('enum'),
            'default' => argument('default'),
        ],
    )->toMatchSnapshot();
})->with('mock');