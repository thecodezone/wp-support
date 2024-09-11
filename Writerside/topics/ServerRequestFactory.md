# ServerRequestFactory

Easily instantiate PSR7 Server requests using GuzzleHTTP's PSR7 server implementation. Useful for testing or for generating requests on the fly. 

## Generate a server request from `$_SERVER` globals. 

```PHP
$server_request = ServerRequestFactory::from_globals();
```

## Instantiate a server request. 

Follows the format of `$_SERVER, $_GET, $_POST, $_COOKIE, $_FILES`, but will be merged with existing super-globals, so it does not request any to be complete. 

```PHP
$server_request = ServerRequestFactory::make( $server, $get, $post, $cookies, $files );
```

## Request

Follows a more traditional request-style API.

```PHP
$server_request = ServerRequestFactory::request( 'GET', 'my/api/path', ['some' => 'params'], ['Content-Type' => 'application/json'] );
```
