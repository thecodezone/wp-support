<?php

require_once __DIR__ . '/../vendor/autoload.php';
function dd() {
    foreach(func_get_args() as $arg) {
        var_dump($arg);
    }
    exit;
}
