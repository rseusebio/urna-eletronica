<?php
require "./start.php";
use Src\Vote;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ($uri[1] == 'vote') {
    // Pegando o id do vereador
    $vereadorId = null;
    if (isset($uri[2])) {
        $vereadorId = (int) $uri[2];
    }

    // Pegando o id do prefeito
    $prefeitoId = null;
    if (isset($uri[3])) {
        $prefeitoId = (int) $uri[3];
    }

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    $controller = new Vote($dbConnection, $requestMethod, $vereadorId, $prefeitoId);
    $controller->processRequest();
}
else if ($uri[1] == 'open' || $uri[1] == 'close' || $uri[1] == 'reset' || $uri[1] == 'status') {
    $controller = new Vote($dbConnection, $requestMethod, $vereadorId, $prefeitoId);
    $controller->processOtherRoutes($uri[1]);
}
else {
    header("HTTP/1.1 404 Not Found");
    exit();
}
