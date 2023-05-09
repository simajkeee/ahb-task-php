<?php

use App\Http\Router;

$router = new Router();

$router->get('/', 'App\Controllers\HomeController@index');
$router->get('/', 'App\Controllers\HomeController@upload');
$router->post('/upload', 'App\Controllers\FileController@upload');