<?php

use App\Http\Router;

$router = new Router();

$router->get('/', 'App\Controllers\HomeController@index');
$router->post('/upload', 'App\Controllers\FileController@upload');