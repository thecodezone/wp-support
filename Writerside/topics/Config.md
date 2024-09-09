# Config

A dot.notation configuration implementation.

```php
$config = new Config( [
  'plugin' => [
    'name' => 'calculator',
    'handle' => 'my-calculator',
    'domain' => 'my_calculator'
  ]] );

$config->get('plugin.handle');
$config->set('plugin.url', site_url() );
$config->merge( [
  'plugin' => [
    'translations' => [
      'greeting' => 'Hello World'
    ] ] ] );
$array = $config->to_array();
```