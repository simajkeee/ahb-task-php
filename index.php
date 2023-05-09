<?php
require 'setup.php';
require 'vendor/autoload.php';
require 'routes.php';

use App\Contracts\Response;
use App\Http\Response as HttpResponse;
use App\Http\ResponseDispatcher;


$dispatcher = new ResponseDispatcher();

try {
    var_dump($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    exit();
    $response = $router->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    if (!($response instanceof Response)) {
        $response = new HttpResponse($response);
    }
    $dispatcher->dispatch($response);
} catch (\Exception $e) {
    if ($e->getCode() === 404) {
        http_response_code(404);
    }
    http_response_code(500);
    // logs
}

