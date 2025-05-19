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
composer require codetetic/pest-plugin-prophecy
```

## Usage

This plugin provides a set of functions to enhance the Pest testing framework with Prophecy capabilities.

### Example Tests

Below are some example tests that demonstrate the features of this plugin:

#### Autowire Example

```php
it('can be autowired', function (): void {
    $object = autowire(Example::class);

    expect($object)
        ->toBeInstanceOf(Example::class);

    expect($object->object)
        ->toBeInstanceOf(stdClass::class);

    expect(argument('object'))
        ->toBeInstanceOf(Prophecy\Prophecy\ObjectProphecy::class);
});
```

#### Argument Tests

```php
it('can be asserted with allOf()', function (): void {
    prophesize(ExampleArgument::class)
        ->string(allOf(exact('format'), type('string')))
        ->shouldBeCalled()
        ->willReturn('result');

    expect(reveal(ExampleArgument::class)->string('format'))
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
