# Cache

A transient-based cache implementation. 

```php
$cache = new Cache( 'my-cache' );
$cache->set('store-this', 'value');
$cache->get('store-this');
$cache->delete('store-this');
$cache->flush();
```