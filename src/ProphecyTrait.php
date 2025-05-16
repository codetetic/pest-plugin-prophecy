<?php

declare(strict_types=1);

namespace Pest\Prophecy;

use InvalidArgumentException;
use PHPUnit\Metadata\After;
use Prophecy\Prophecy\ObjectProphecy;
use ReflectionClass;
use ReflectionNamedType;

trait ProphecyTrait
{
    use \Prophecy\PhpUnit\ProphecyTrait;

    protected array $arguments = [];
    protected array $prophecies = [];

    /**
     * @template T of object
     * @phpstan-param class-string<T> $classOrInterface
     * @phpstan-return ObjectProphecy<T>
     */
    protected function prophesizeWithCache(string $classOrInterface, string $key = ''): ObjectProphecy
    {
        $this->prophecies[$classOrInterface] = $this->prophesize($classOrInterface);
        return $this->prophecies[$classOrInterface];
    }

    /**
     * @template T of object
     * @phpstan-param class-string<T> $classOrInterface
     * @phpstan-return T
     */
    protected function getProphecy(string $classOrInterface, string $key = ''): ?ObjectProphecy
    {
        return $this->prophecies[$classOrInterface];
    }

    protected function autowire(string $class, array $defaults = []): object
    {
        $this->arguments = [];
        $reflected = new ReflectionClass($class);

        $parameters = $reflected->getConstructor()?->getParameters() ?? [];
        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            $this->arguments[$name] = match (true) {
                isset($defaults[$name]) => $defaults[$name],
                $type instanceof ReflectionNamedType && !$type->isBuiltin() => $this->prophesize($type->getName()),
                $parameter->isDefaultValueAvailable() => $parameter->getDefaultValue(),
                default => throw new InvalidArgumentException("Unable to autowire {$class}: {$name} with {$type} mock"),
            };
        }

        return $reflected->newInstanceArgs(
            array_map(
                fn(mixed $mixed): mixed => $mixed instanceof ObjectProphecy? $mixed->reveal(): $mixed,
                $this->arguments,
            ),
        );
    }

    protected function getArgument(string $key): mixed
    {
        if (isset($this->arguments[$key])) {
            return $this->arguments[$key];
        }
        return null;
    }

    #[After]
    protected function resetArgumentsAndProphecies(): void
    {
        $this->arguments = [];
        $this->prophecies = [];
    }
}