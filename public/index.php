<?php

require_once '../vendor/autoload.php';

date_default_timezone_set('America/Sao_Paulo');

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

new App\Core\Router();
