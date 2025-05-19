<?php

declare(strict_types=1);

namespace Pest\Prophecy;

use PHPUnit\Metadata\After;
use Prophecy\Prophecy\ObjectProphecy;

trait ProphecyTrait
{
    use \Prophecy\PhpUnit\ProphecyTrait {
        prophesize as baseProphesize;
    }

    protected array $arguments = [];
    protected array $prophecies = [];

    /**
     * @template T of object
     *
     * @phpstan-param class-string<T> $classOrInterface
     *
     * @phpstan-return ObjectProphecy<T>
     */
    protected function prophesize(?string $classOrInterface = null, string $key = ''): ObjectProphecy
    {
        if (isset($this->prophecies[$classOrInterface.$key])) {
            throw new \InvalidArgumentException('Prophecy already exists.');
        }

        $this->prophecies[$classOrInterface.$key] = $this->baseProphesize($classOrInterface);

        return $this->prophecies[$classOrInterface];
    }

    /**
     * @template T of object
     *
     * @phpstan-param class-string<T> $classOrInterface
     *
     * @phpstan-return T|null
     */
    protected function getProphecy(string $classOrInterface, string $key = ''): ?ObjectProphecy
    {
        return $this->prophecies[$classOrInterface.$key] ?? null;
    }

    /**
     * @template T of object
     *
     * @phpstan-param class-string<T> $classOrInterface
     *
     * @phpstan-return T
     */
    protected function autowire(string $classOrInterface, array $defaults = []): object
    {
        $this->arguments = [];
        $reflected = new \ReflectionClass($classOrInterface);

        $parameters = $reflected->getConstructor()?->getParameters() ?? [];
        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            $this->arguments[$name] = match (true) {
                isset($defaults[$name]) => $defaults[$name],
                $type instanceof \ReflectionNamedType && !$type->isBuiltin() => $this->baseProphesize($type->getName()),
                $parameter->isDefaultValueAvailable() => $parameter->getDefaultValue(),
                default => throw new \InvalidArgumentException("Unable to autowire {$classOrInterface}: {$name} with {$type} mock"),
            };
        }

        return $reflected->newInstanceArgs(
            array_map(
                fn (mixed $mixed): mixed => $mixed instanceof ObjectProphecy ? $mixed->reveal() : $mixed,
                $this->arguments,
            ),
        );
    }

    protected function getArgument(string $key): mixed
    {
        return $this->arguments[$key] ?? null;
    }

    #[After]
    protected function resetArgumentsAndProphecies(): void
    {
        $this->arguments = [];
        $this->prophecies = [];
    }
}
