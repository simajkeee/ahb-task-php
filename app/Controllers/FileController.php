<?php

namespace App\Controllers;

use App\Helpers\FileUploadHelper;
use App\Http\JsonResponse;
use App\Services\CSVParser;

class FileController
{
    public function upload()
    {
        $uploadHelper = new FileUploadHelper();
        $parser = new CSVParser();

        $file = $uploadHelper->getUploadFile();
        $parsedCSVModel = $parser->parseBatches($file, $_REQUEST['page'] ?? 1);

        return new JsonResponse($parsedCSVModel);
    }
}