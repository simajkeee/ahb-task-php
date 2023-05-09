<?php

namespace App\Http;

use App\Contracts\Response;

class ResponseDispatcher
{
    public function dispatch(Response $response)
    {
        http_response_code($response->getCode());
        echo $response;
    }
}