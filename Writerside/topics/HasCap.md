# HasCap Middleware

Pass a standard or custom WordPress capability. If the user does not have the capability, the route will be `Unauthorized`. 

```php
$router->get('/hello-world', 'Acme/HelloWorldController::page')
    ->middleware(new HasCap('read'));
```
