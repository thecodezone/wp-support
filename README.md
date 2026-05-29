
<p align="center">
  <a href="https://codezone.io/">
    <img alt="CodeZone" src="https://prismic-io.s3.amazonaws.com/codezone/5f2169a6-d854-478d-b0d4-93e8b18d0bb7_cz-lines-orange-dark.svg" height="100">
  </a>
</p>

WordPress Support
--------------------

A suite of framework helpers for making WordPress theme and plugin development easier. 

## Features

- **Dependency Injection**: Simple container wrapper and service provider factory.
- **Configuration**: Dot-notation configuration loader and manager.
- **Cache**: Wrapper for WordPress transients with scoping.
- **Options**: Managed WordPress options with defaults and scoping.
- **Routing**: Integration with `league/route` for custom REST endpoints.
- **Middleware**: Common WordPress-specific middleware (Nonces, Capabilities).

## Requirements

- PHP 7.4 or higher (Development uses PHP 8.1+)
- WordPress 5.6 or higher

## Installation

```bash
composer require codezone/wp-support
```

## Documentation

Full documentation is available at [https://thecodezone.github.io/wp-support/](https://thecodezone.github.io/wp-support/).

## Development

### Setup

```bash
composer install
```

### Linting

```bash
composer lint
```

### Testing

```bash
composer test
```

### Versioning

```bash
composer version
```
