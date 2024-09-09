# Rewrites

A rewrite manager that allows for checking if rewrite rules valid for a particular instance, or if they need to be flushed and rewritten. 

```php
$rewrites = new Rewrites( $rules );
if (!$rewrites->has_latest()) {
  $rewrites->flush();
}
```

or more simply:

```php
$rewrites = new Rewrites( $rules );
$rewrites->sync():
```

## Flushing the rewrite rules

```php
$rewrites->flush();
```

## Checking if the current instance has the latest rules

```php
$rewrites->has_latest();
```


## Checking if a specific rewrite exists

```php
$rewrites->exists( '^wp/plugin/?$' );
```

### Checking if a specific rule and query exists

```php
$rewrites->exists( '^wp/plugin/?$', 'index.php?wp-plugin=/' );
```

### Adding a rewrite rule

```php
$rewrites->add( '^wp/plugin/?$', 'index.php?wp-plugin=/' );
```

### Apply all loaded rules

```php
$rewrites = new Rewrites( $rules );
$rewrites->apply();
```


### Sync the rules

if the instances rewrite rules aren't current, refresh them.

```php
$rewrites->sync();
```

### Flush and reapply the rules

```php
$rewrites->flush();
```