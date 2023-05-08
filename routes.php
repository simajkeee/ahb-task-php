<?php

use App\Http\Router;

$router = new Router();

$router->post('/upload', 'App\Controllers\FileController@upload');