<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$db = (new Database())->connect();

$authController = new AuthController($db);

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$method = $_SERVER["REQUEST_METHOD"];

switch ($uri)
{
    case "/api/register":

        if($method === "POST"){
            $authController->register();
        }

        break;

    case "/api/login":

        if($method === "POST"){
            $authController->login();
        }

        break;

    case "/api/logout":

        if($method === "POST"){
            $authController->logout();
        }

        break;

    default:

        http_response_code(404);

        echo json_encode([
            "message" => "Route introuvable"
        ]);
    require_once __DIR__ . '/../controllers/DestinationController.php';

$destinationController = new DestinationController($db);
}
