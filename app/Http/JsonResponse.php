<?php

namespace App\Http;

use App\Contracts\Response;

class JsonResponse implements Response
{
    public function __construct(public $data, public int $code = 200)
    {
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }
}