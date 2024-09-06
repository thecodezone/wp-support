
<p align="center">
  <a href="https://codezone.io/">
    <img alt="CodeZone" src="https://prismic-io.s3.amazonaws.com/codezone/5f2169a6-d854-478d-b0d4-93e8b18d0bb7_cz-lines-orange-dark.svg" height="100">
  </a>
</p>


WordPress Support
--------------------

A suite of helpers for making WordPress theme and plugin development easier. These utility classes are meant to be used as singletons, or with a container like [league/container](https://container.thephpleague.com/).

# Installation

`composer require codezone/wp-support`

## Assets

Pass an array of allowed script and style handles. Any handle not includes will be removed from the WordPress asset queue. This also works with the [vite-4-wp](https://github.com/kucrut/vite-for-wp) assets. 

```php
$asset_queue = new AssetQueue();
$asset_queue->filter(
    [ 'your_style' ],
    [ 'your_script' ]
);
```
## Cache

A transient-based cache implementation. 

```php
$cache = new Cache( 'my-cache' );
$cache->set('store-this', 'value');
$cache->get('store-this');
$cache->delete('store-this');
$cache->flush();
```

## Config

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
    'translations => [
      'greeting' => 'Hello World'
    ] ] ] );
$array = $config->to_array();
```

## ContainerFactory

A simple implementation of [league/container](https://container.thephpleague.com/).

```php
$container = ContainerFactory::make();
```

## Middleware

The following [league/route](https://route.thephpleague.com/) middleware are provided: 

### HasCap

Pass a standard or custom WordPress capability. If the user does not have the capability, the route will be `Unauthorized`. 

```php
$router->get('/hello-world', 'Acme/HelloWorldController::page')->middleware(new HasCap('read'));
```

### Nonce

A nonce header, query variable or post variable must be present in order for the user to visit the route. If not, the route will be `Unauthorized`. 

```php
$router->get('/hello-world', 'Acme/HelloWorldController::page')->middleware(new Nonce('my-nonce'));
```

## Options

Simplifies working with the wordpress options API. Eliminiates the need to check if optinos are created before using update option. Scopes option keys by a prefix.  

```php
$options = new Options( $defaults, $prefix );
$options->set( "background_color", "red" );
$color = $options->get( "background_color" );
```

## Rewrites

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








