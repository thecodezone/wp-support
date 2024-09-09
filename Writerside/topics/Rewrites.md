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