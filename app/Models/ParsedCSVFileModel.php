<?php

namespace App\Models;

use App\Contracts\Model;

class ParsedCSVFileModel implements Model
{
    public array $rows;

    public bool $endFile = false;
}