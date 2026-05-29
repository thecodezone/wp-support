

# WP Support

A suite of helpers for making WordPress theme and plugin development easier. These utility classes are meant to be used as singletons, or with a container like [league/container](https://container.thephpleague.com/).

![CZ](cz-lines-orange-dark.svg){ width=100 }

by [CodeZone](http://codezone.io)

## Features

- **Dependency Injection**: Simple container wrapper and service provider factory.
- **Configuration**: Dot-notation configuration loader and manager.
- **Cache**: Wrapper for WordPress transients with scoping.
- **Options**: Managed WordPress options with defaults and scoping.
- **Routing**: Integration with `league/route` for custom REST endpoints.
- **Middleware**: Common WordPress-specific middleware (Nonces, Capabilities).

## Installation

```bash
composer require codezone/wp-support
```