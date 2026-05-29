

# WP Support

A suite of helpers for making WordPress theme and plugin development easier. These utility classes are meant to be used as singletons, or with a container like [league/container](https://container.thephpleague.com/).

![CZ](cz-lines-orange-dark.svg){ width=100 }

by [CodeZone](http://codezone.io)

## Features

- **Dependency Injection**: Simple [container wrapper](ContainerFactory.md) and [service provider factory](ProviderFactory.md).
- **Configuration**: Dot-notation [configuration loader](Config.md) and manager.
- **Cache**: Wrapper for WordPress [transients](Cache.md) with scoping.
- **Options**: Managed WordPress [options](Options.md) with defaults and scoping.
- **Routing**: Integration with [league/route](Route.md) for custom REST endpoints.
- **Middleware**: Common WordPress-specific [middleware](Middleware.md) (Nonces, Capabilities).
- **Factories**: Helpers for [Server Requests](ServerRequestFactory.md) and [Responses](ResponseFactory.md).

## Installation

```bash
composer require codezone/wp-support
```