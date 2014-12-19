<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 15.12.2014
 * Time: 10:38
 */

require_once "settings.php";

require_once "RequestMapper.php";
require_once "MVCClasses/View.php";
require_once "MVCClasses/Model.php";
require_once "MVCClasses/IController.php";

/* --- */

$request_url = $_SERVER['REQUEST_URI'];

$requestMapper = new RequestMapper();
$cuts = array("?", "/index.php", "/index.html", "/index.htm");

$requestMapper->setCuts($cuts, $request_url);
$relation = $requestMapper->requestMap($request_url);

if($relation["errors"]){
    $requestMapper->toErrorPage(404);
}
(!empty($relation['controller'])) ? $controller_name = $relation['controller'] : die("Controller name is null");
(!empty($relation['action'])) ? $action_name = $relation['action'] : die("Action name is null");

if(file_exists(CONTROLLERS_FOLDER."/".$controller_name.".php")) include_once CONTROLLERS_FOLDER."/".$controller_name.".php"; else die("Controller class not found");

try {
    $controller = new $controller_name();
    $view = $controller->$action_name($relation["params"]);
    $model = $view->model;
}catch(Exception $e){
    echo "Exception : \n -Code:".$e->getCode()."\n Message:".$e->getMessage();
}



