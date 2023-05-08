<?php

namespace App\Http;

use App\Contracts\Response;

class ResponseDispatcher
{
    public function dispatch(Response $response)
    {
        http_response_code($response->getCode());
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($response instanceof JsonResponse) {
            header("Content-Type: application/json");
        }

        echo $response;
    }
}