<?php

require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/DestinationController.php';
require_once __DIR__ . '/../controllers/HebergementController.php';
require_once __DIR__ . '/../controllers/ReservationHebergementController.php';
require_once __DIR__ . '/../controllers/TransportController.php';
require_once __DIR__ . '/../controllers/ReservationTransportController.php';

$db = (new Database())->connect();

$authController = new AuthController($db);

$destinationController = new DestinationController($db);

$hebergementController = new HebergementController($db);

$reservationHebergementController =
    new ReservationHebergementController($db);

$transportController =
    new TransportController($db);

$reservationTransportController =
    new ReservationTransportController($db);

$uri = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

$method = $_SERVER['REQUEST_METHOD'];

if ($uri === "/api/register" && $method === "POST")
{
    $authController->register();
    exit;
}

if ($uri === "/api/login" && $method === "POST")
{
    $authController->login();
    exit;
}

if ($uri === "/api/logout" && $method === "POST")
{
    $authController->logout();
    exit;
}

if ($uri === "/api/destinations" && $method === "GET")
{
    $destinationController->getAll();
    exit;
}

if ($uri === "/api/destinations" && $method === "POST")
{
    $destinationController->create();
    exit;
}

if ($uri === "/api/destinations/search")
{
    $destinationController->search();
    exit;
}

if ($uri === "/api/destinations/filter")
{
    $destinationController->filter();
    exit;
}

if (
    preg_match(
        '#^/api/destinations/([0-9]+)$#',
        $uri,
        $matches
    )
)
{
    $id = $matches[1];

    if ($method === "GET")
    {
        $destinationController->getById($id);
    }

    if ($method === "PUT")
    {
        $destinationController->update($id);
    }

    if ($method === "DELETE")
    {
        $destinationController->delete($id);
    }

    exit;
}

if ($uri === "/api/hebergements" && $method === "GET")
{
    $hebergementController->getAll();
    exit;
}

if ($uri === "/api/hebergements" && $method === "POST")
{
    $hebergementController->create();
    exit;
}

if ($uri === "/api/hebergements/search")
{
    $hebergementController->search();
    exit;
}

if ($uri === "/api/hebergements/filter")
{
    $hebergementController->filter();
    exit;
}

if (
    preg_match(
        '#^/api/hebergements/([0-9]+)$#',
        $uri,
        $matches
    )
)
{
    $id = $matches[1];

    if ($method === "GET")
    {
        $hebergementController->getById($id);
    }

    if ($method === "PUT")
    {
        $hebergementController->update($id);
    }

    if ($method === "DELETE")
    {
        $hebergementController->delete($id);
    }

    exit;
}

if (
    $uri === "/api/hebergements/reserver"
    && $method === "POST"
)
{
    $reservationHebergementController->reserver();
    exit;
}

if (
    preg_match(
        '#^/api/hebergements/annuler/([0-9]+)$#',
        $uri,
        $matches
    )
)
{
    if ($method === "DELETE")
    {
        $reservationHebergementController
            ->annuler($matches[1]);
    }

    exit;
}

if ($uri === "/api/transports" && $method === "GET")
{
    $transportController->getAll();
    exit;
}

if ($uri === "/api/transports" && $method === "POST")
{
    $transportController->create();
    exit;
}

if ($uri === "/api/transports/search")
{
    $transportController->search();
    exit;
}

if (
    preg_match(
        '#^/api/transports/([0-9]+)$#',
        $uri,
        $matches
    )
)
{
    $transportController->getById(
        $matches[1]
    );

    exit;
}

if (
    $uri === "/api/transports/reserver"
    && $method === "POST"
)
{
    $reservationTransportController
        ->reserver();

    exit;
}

if (
    preg_match(
        '#^/api/transports/annuler/([0-9]+)$#',
        $uri,
        $matches
    )
)
{
    if ($method === "DELETE")
    {
        $reservationTransportController
            ->annuler($matches[1]);
    }

    exit;
}

http_response_code(404);

echo json_encode([
    "message" => "Route introuvable"
]);

exit;
