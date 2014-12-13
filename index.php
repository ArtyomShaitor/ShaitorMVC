<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 13.12.2014
 * Time: 17:01
 */

require_once "core/Route.php";
require_once "core/View.php";
require_once "core/Model.php";
require_once "core/Controller.php";

/* --- */

$request_url = $_SERVER['REQUEST_URI'];
$Route = new Route();
$relation = $Route->requestMap($request_url);

if($relation["errors"]){
    $Route->toErrorPage(404);

}
(!empty($relation['controller'])) ? $controller_name = $relation['controller'] : die("Controller name is null");
(!empty($relation['action'])) ? $action_name = $relation['action'] : die("Action name is null");

if(file_exists("controllers/".$controller_name.".php")) include_once "controllers/".$controller_name.".php"; else die("Controller class not found");

$controller = new $controller_name();
$action = $controller->$action_name($relation["params"]);

$view = $action;
$model = $view->model;

include_once "views/".$view->getPageURL();
