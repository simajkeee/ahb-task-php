<?php

namespace App\Contracts;

interface Response
{
    public function getCode(): int;

    public function __toString(): string;
}