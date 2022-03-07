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

// endpoints starting with `/vote`
// everything else results in a 404 Not Found
if ($uri[1] !== 'vote') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

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