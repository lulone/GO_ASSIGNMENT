<?php
require "../bootstrap.php";

use Src\Controller\ShoeController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// all of our endpoints start with /shoe
// everything else results in a 404 Not Found
if ($uri[1] !== 'shoe') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$shoeId = null;
if (isset($uri[2])) {
    $shoeId = (int) $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and user ID to the PersonController and process the HTTP request:
$controller = new ShoeController($dbConnection, $requestMethod, $shoeId);
$controller->processRequest();
