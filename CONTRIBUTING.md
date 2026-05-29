Thank you for contributing to WP Support! These are the guidelines we expect you to follow when writing code for this library.

### Coding Standards

We use [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer) and [WordPress Coding Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) to ensure code quality and consistency.

You can run the linter locally using DDEV:

```bash
ddev composer lint
```

We expect all pull requests to pass linting and tests.

### Testing

We use PHPUnit for testing. Please ensure that your changes include relevant tests and that all existing tests pass.

```bash
ddev composer test
```

### GitHub Workflow

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Commit your changes.
4. Create a pull request into the `main` branch.

### Translations (if applicable)

Any user-facing strings should be translatable using WordPress i18n functions:

```php
esc_html__( 'My String', 'wp-support' );
```

We look forward to your contributions!
