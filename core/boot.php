<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 15.12.2014
 * Time: 10:38
 */

require_once "settings.php";

require_once "Route.php";
require_once "View.php";
require_once "Model.php";
require_once "Controller.php";

/* --- */

$request_url = $_SERVER['REQUEST_URI'];
$Route = new Route();
$relation = $Route->requestMap($request_url);

if($relation["errors"]){
    $Route->toErrorPage(404);

}
(!empty($relation['controller'])) ? $controller_name = $relation['controller'] : die("Controller name is null");
(!empty($relation['action'])) ? $action_name = $relation['action'] : die("Action name is null");

if(file_exists(CONTROLLERS_FOLDER."/".$controller_name.".php")) include_once CONTROLLERS_FOLDER."/".$controller_name.".php"; else die("Controller class not found");

$controller = new $controller_name();
$view = $controller->$action_name($relation["params"]);

$model = $view->model;


