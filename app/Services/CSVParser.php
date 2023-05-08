<?php

namespace App\Services;

use App\Contracts\Model;
use App\Models\File;
use App\Models\ParsedCSVFileModel;

class CSVParser
{
    public function parseBatches(File $file, int $batchNumber = 1, int $itemsPerBatch = 1000): Model
    {
        if ($file->getType() !== 'text/csv') {
            throw new \Exception('wrong file type provided: ' . $file->getType() . '. unable to parse.');
        }

        return $this->getParsedResult($file, $batchNumber, $itemsPerBatch);
    }

    private function getParsedResult(File $file, int $batchNumber, int $itemsPerBatch): ParsedCSVFileModel
    {
        $model = new ParsedCSVFileModel();
        $file = new \SplFileObject($file->getPath());

        foreach ($this->readTheFile($file, $batchNumber, $itemsPerBatch) as $row) {
            $model->rows[] = $row;
        }

        $model->endFile = $file->eof();
        $file = null;
        return $model;
    }

    private function parseRow(array $line)
    {
        foreach ($line as $spLine) {
            if ($spLine === "") {
                yield (array)$spLine;
            } else if (preg_match('/\"(.*)\"/', $spLine, $matches)) {
                yield (array)$matches[1];
            } else {
                yield explode(';', $spLine);
            }
        }
    }

    private function readTheFile(\SplFileObject $file, int $batchNumber, int $batchSize)
    {
        $start = $batchSize * ($batchNumber - 1);
        $limit = $batchSize * $batchNumber;

        $file->seek($start);

        while (!$file->eof() && $start < $limit) {
            $line = trim($file->current());
            $splitLine = explode(',', $line);
            $row = [];
            foreach ($this->parseRow($splitLine) as $readItem) {
                $row = array_merge($row, $readItem);
            }
            $start++;
            $file->next();
            yield $row;
        }
    }
}