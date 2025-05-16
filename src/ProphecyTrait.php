<?php

declare(strict_types=1);

namespace Pest\Prophecy;

use InvalidArgumentException;
use Prophecy\Prophecy\ObjectProphecy;
use ReflectionClass;
use ReflectionNamedType;

trait ProphecyTrait
{
    use \Prophecy\PhpUnit\ProphecyTrait;

    protected array $arguments = [];

    protected ?ObjectProphecy $last = null;

    /**
     * @template T of object
     * @phpstan-param class-string<T>|null $classOrInterface
     * @phpstan-return ($classOrInterface is null ? ObjectProphecy<object> : ObjectProphecy<T>)
     */
    protected function prophesizeWithCache(?string $classOrInterface = null): ObjectProphecy
    {
        $this->last = $this->prophesize($classOrInterface);
        return $this->last;
    }

    protected function getLastProphecy(): ?ObjectProphecy
    {
        return $this->last;
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
}