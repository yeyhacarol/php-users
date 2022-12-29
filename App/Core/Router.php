<?php

namespace App\Core;

class Router
{
    private $controller;

    private $httpMethod;

    private $controllerMethod;

    private $params = [];

    function __construct()
    {

        $url = $this->parseURL();

        if (file_exists("../App/Controllers/" . ucfirst($url[1]) . ".php")) {

            $this->controller = $url[1];
            unset($url[1]);
        } elseif (empty($url[1])) {

            echo "Bem-vindo a API para teste da Alphacode.";

            exit;
        } else {
            http_response_code(404);
            echo json_encode(["erro" => "Recurso não encontrado."]);

            exit;
        }

        require_once "../App/Controllers/" . ucfirst($this->controller) . ".php";

        $this->controller = new $this->controller;

        $this->httpMethod = $_SERVER["REQUEST_METHOD"];

        switch ($this->httpMethod) {
            case "GET":
                $this->controllerMethod = "index";
                break;

            case "POST":
                $this->controllerMethod = "store";
                break;

            case "PUT":
                $this->controllerMethod = "update";

                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->params = [$url[2]];
                } else {
                    http_response_code(400);
                    echo json_encode(["erro" => "É necessário informar um id."]);
                    exit;
                }
                break;

            case "DELETE":
                $this->controllerMethod = "delete";

                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->params = [$url[2]];
                } else {
                    http_response_code(400);
                    echo json_encode(["erro" => "É necessário informar um id."]);
                    exit;
                }
                break;

            default:
                echo json_encode(["erro" => "Método não suportado."]);
                exit;
                break;
        }

        call_user_func_array([$this->controller, $this->controllerMethod], $this->params);
    }

    private function parseURL()
    {
        return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    }
}
