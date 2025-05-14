<?php

use function Pest\Prophecy\{prophesize, exact, type, which};

it('can be mocked with exact argument', function (): void {
    $mock = prophesize(DateTime::class);
    $mock->format(exact('format'))->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});

it('can be mocked with type argument', function (): void {
    $mock = prophesize(DateTime::class);
    $mock->format(type('string'))->willReturn('result');

    expect($mock->reveal()->format('format'))
        ->toBe('result');
});

class ArgumentTest1
{
    public function test(stdClass $object): string
    {
        return 'test';
    }
}

it('can be mocked with which argument', function (): void {
    $mock = prophesize(ArgumentTest1::class);
    $mock->test(which('format', 'string'))->willReturn('result');

    $object = new stdClass();
    $object->format = 'string';

    expect($mock->reveal()->test($object))
        ->toBe('result');
});