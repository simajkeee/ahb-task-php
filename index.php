<?php

use App\Http\ResponseDispatcher;

require 'vendor/autoload.php';
require 'routes.php';

$dispatcher = new ResponseDispatcher();

try {
    $response = $router->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    $dispatcher->dispatch($response);
} catch (\Exception $e) {
    if ($e->getCode() === 404) {
        http_response_code(404);
    }
    // logs
}

