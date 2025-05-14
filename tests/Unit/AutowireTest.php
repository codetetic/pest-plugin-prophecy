<?php

use function Pest\Prophecy\{autowire, argument};

enum ExampleEnum: string
{
    case TEST = 'test';
}

class Example
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
        public ExampleEnum $enum,
        public string $default = 'default',
    ) {}
}

it('can be autowired', function (): void {
    // @var Example $object
    $object = autowire(
        Example::class,
        [
            'dateTimeUnion' => new DateTime('2000-01-02 00:00:00'),
            'dateTimeIntersection' => new DateTime('2000-01-03 00:00:00'),
            'string' => 'string',
            'int' => 1,
            'float' => 1.1,
            'bool' => true,
            'enum' => ExampleEnum::TEST,
        ],
    );

    expect(
        $object
    )->toBeInstanceOf(Example::class);

    expect(
        argument('dateTime')
    )->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);

    expect(
        $object->dateTime,
    )->toBeInstanceOf(DateTime::class);

    expect(
        get_class($object->dateTime)
    )->toBe('Double\DateTime\P1');

    expect(
        argument('dateTimeUnion')
    )->toBeInstanceOf(DateTime::class);

    expect(
        argument('dateTimeIntersection')
    )->toBeInstanceOf(DateTime::class);

    expect(
        argument('string')
    )->toBe('string');

    expect(
        argument('int')
    )->toBe(1);

    expect(
        argument('float')
    )->toBe(1.1);

    expect(
        argument('bool')
    )->toBe(true);

    expect(
        argument('enum')
    )->toBe(ExampleEnum::TEST);

    expect(
        argument('default')
    )->toBe('default');

    expect(
        argument('dateTimeWithDefault')
    )->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);
});