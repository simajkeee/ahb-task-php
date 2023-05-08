<?php

namespace App\Http;

use App\Contracts\Response as IResponse;

class Response implements IResponse
{
    public function __construct(public string $data, public int $code = 200)
    {
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return $this->data;
    }
}