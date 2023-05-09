<?php
$configHeader = require('./config/headers.php');

if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
    $configHeader = array_merge($configHeader, ['Content-Type' => 'application/json']);
}

foreach ($configHeader as $header => $value) {
    $parsedHeader = sprintf("%s: %s", $header, $value);
    header($parsedHeader);
}