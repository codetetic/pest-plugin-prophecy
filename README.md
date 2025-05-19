# Pest Prophecy Plugin

This project is a Pest Prophecy Plugin that provides additional assertion capabilities for testing in PHP using the Prophecy library.

## Prerequisites

- PHP 8.1 or higher
- PestPHP 2.36 or higher
- Prophecy 1.22 or higher
- Composer

## Installation

Install the package via Composer:

```bash
composer require --dev codetetic/pest-plugin-prophecy
```

## Usage

This plugin provides a set of functions to enhance the Pest testing framework with Prophecy capabilities.

### Example Tests

Below are some example tests that demonstrate the features of this plugin:

#### Basic Example

```php
use function Pest\Prophecy\prophesize;
use function Pest\Prophecy\reveal;

class Example
{
}

it('can be accessed as a function', function (): void {
    $prophecy = prophesize(Example::class);

    expect($prophecy)
        ->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);

    expect($prophecy->reveal())
        ->toBeInstanceOf(Example::class);
});

it('can be accessed as a function and use reveal helper', function (): void {
    expect(prophesize(Example::class))
        ->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);

    expect(reveal(Example::class))
        ->toBeInstanceOf(Example::class);
});
```

#### Autowire Example

```php
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
```

#### Argument Tests

```php
use function Pest\Prophecy\prophesize;
use function Pest\Prophecy\reveal;
use function Pest\Prophecy\allOf;
use function Pest\Prophecy\exact;
use function Pest\Prophecy\type;

class Example
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

it('can be asserted with allOf()', function (): void {
    prophesize(Example::class)
        ->string(allOf(exact('format'), type('string')))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(Example::class)->string('format'))
        ->toBe('result');
});

it('can be asserted with allOf()', function (): void {
    prophesize(Example::class)
        ->string(allOf(exact('format'), type('string')))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(Example::class)->string('format'))
        ->toBe('result');
});

// More tests demonstrating the use of different argument tokens like `any`, `exact`, `in`, `notIn`, `size`, `withEntry`, etc.
```

## License

This project is licensed under the MIT License. See the LICENSE.md file for details.

## Contributing

Contributions are welcome! Please submit a pull request or create an issue for any bugs or feature requests.

## Contact

For any inquiries, please contact Peter Measham at github@codetetic.co.uk.
