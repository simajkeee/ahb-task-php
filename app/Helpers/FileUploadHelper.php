<?php

namespace App\Helpers;

use App\Constants\HttpMethods;
use App\Models\File;

class FileUploadHelper
{
    public function getUploadFile(): File
    {
        if ($_SERVER['REQUEST_METHOD'] !== HttpMethods::POST) {
            throw new \Exception("unable to handle file upload. wrong http method.");
        }

        if (!isset($_FILES['file'])) {
            throw new \Exception("no file has been provided");
        }

        $file = $_FILES['file'];
        $uploadError = $file['error'];

        if ($uploadError !== UPLOAD_ERR_OK && $err = $this->checkUploadError($uploadError)) {
            throw new \Exception($err);
        }

        return new File($file['name'], $file['type'], $file['size'], $file['tmp_name']);
    }

    private function checkUploadError($uploadError)
    {
        return match ($uploadError) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the maximum file size limit.",
            UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded.",
            UPLOAD_ERR_NO_FILE => "No file was uploaded.",
            UPLOAD_ERR_NO_TMP_DIR => "Missing temporary folder.",
            UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
            UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload.",
            default => "Unknown error occurred during file upload.",
        };
    }
}