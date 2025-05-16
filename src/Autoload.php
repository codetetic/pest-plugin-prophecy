<?php

declare(strict_types=1);

namespace Pest\Prophecy;

use Prophecy\Argument;
use Prophecy\Argument\Token;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @template T of object
 * @phpstan-param class-string<T>|null $classOrInterface
 * @phpstan-return ($classOrInterface is null ? ObjectProphecy<object> : ObjectProphecy<T>)
 */
function prophesize(?string $classOrInterface = null, string $key = ''): ObjectProphecy
{
    return test()->prophesizeWithCache($classOrInterface, $key);
}

/**
 * @template T of object
 * @phpstan-param class-string<T> $classOrInterface
 * @phpstan-return T
 */
function reveal(string $classOrInterface, string $key = ''): mixed
{
    return test()->getProphecy($classOrInterface, $key)->reveal();
}

/**
 * @template T of object
 * @phpstan-param class-string<T> $class
 * @phpstan-return T
 */
function autowire(string $class, array $defaults = []): object
{
    return test()->autowire($class, $defaults);
}

function argument(string $key): mixed
{
    return test()->getArgument($key);
}

function exact(mixed $value): Token\ExactValueToken
{
    return Argument::exact($value);
}

function type(string $type): Token\TypeToken
{
    return Argument::type($type);
}

function which(string $methodName, mixed $value): Token\ObjectStateToken
{
    return Argument::which($methodName, $value);
}

function that(callable $callback): Token\CallbackToken
{
    return Argument::that($callback);
}

function any(): Token\AnyValueToken
{
    return Argument::any();
}

function cetera(): Token\AnyValuesToken
{
    return Argument::cetera();
}

function allOf(...$tokens): Token\LogicalAndToken
{
    return Argument::allOf(...$tokens);
}

function size(int $value): Token\ArrayCountToken
{
    return Argument::size($value);
}

function withEntry(mixed $key, mixed $value): Token\ArrayEntryToken
{
    return Argument::withEntry($key, $value);
}

function withEveryEntry(mixed $value): Token\ArrayEveryEntryToken
{
    return Argument::withEveryEntry($value);
}

function containing(mixed $value): Token\ArrayEntryToken
{
    return Argument::containing($value);
}

function withKey(mixed $key): Token\ArrayEntryToken
{
    return Argument::withKey($key);
}

function not(mixed $value): Token\LogicalNotToken
{
    return Argument::not($value);
}

function containingString(string $value): Token\StringContainsToken
{
    return Argument::containingString($value);
}

function is(mixed $value): Token\IdenticalValueToken
{
    return Argument::is($value);
}

function approximate(float $value, int $precision = 0): Token\ApproximateValueToken
{
    return Argument::approximate($value, $precision);
}

function in(array $value): Token\InArrayToken
{
    return Argument::in($value);
}

function notIn(array $value): Token\NotInArrayToken
{
    return Argument::notIn($value);
}
