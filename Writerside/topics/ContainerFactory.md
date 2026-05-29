# ContainerFactory

A simple implementation of [league/container](https://container.thephpleague.com/).

The `ContainerFactory` manages a singleton instance of the container, or allows you to create new instances.

## Basic Usage

To create a new instance of the container:

```php
$container = ContainerFactory::make();
```

## Singleton Usage

In most WordPress plugins, you'll want a single container instance shared across your components.

```php
$container = ContainerFactory::singleton();
```

To reset the singleton instance (useful for testing):

```php
ContainerFactory::forget();
```

## Delegates

By default, `ContainerFactory::make()` adds a `ReflectionContainer` as a delegate, allowing for automatic dependency resolution.
