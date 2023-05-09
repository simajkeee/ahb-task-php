<?php
$configHeader = require('./config/headers.php');

if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $configHeader = array_merge($configHeader, ['Content-Type' => 'application/json']);
}

foreach ($configHeader as $header => $value) {
    header(sprintf("%s: %s", $header, $value));
}