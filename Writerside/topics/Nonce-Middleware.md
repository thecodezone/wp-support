# Nonce Middleware

```php
$router->get('/hello-world', 'Acme/HelloWorldController::page')
    ->middleware( new Nonce('my-nonce') );
```
