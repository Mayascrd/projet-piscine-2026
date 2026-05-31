<?php

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: *");

header("Access-Control-Allow-Methods: *");

if($_SERVER["REQUEST_METHOD"] === "OPTIONS")
{
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/routes/api.php';
