<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 13.12.2014
 * Time: 8:47
 */


require_once "core/Route.php";

/* --- */

$request_url = $_SERVER['REQUEST_URI'];
$Route = new Route();
$relation = $Route->requestMap($request_url);

if($relation["errors"]){
//    include_once "errors/error.html";
    die("Page not found");

}
(!empty($relation['controller'])) ? $controller_name = $relation['controller'] : die("Controller name is null");
(!empty($relation['action'])) ? $action_name = $relation['action'] : die("Action name is null");

if(file_exists("controllers/".$controller_name.".php")) include_once "controllers/".$controller_name.".php"; else die("Controller class not found");

$controller = new $controller_name();
$action = $controller->$action_name();

include_once "views/".$action;






//$string = "/{number}";
//
//$patterns = array();
//$replacements = array();
//
//$replacements[0] = "/\{[a-zA-Z]+\}/";
//$replacements[1] = "(\d+)";
//
//$patterns[0] = "/{string}/";
//$patterns[1] = "/{number}/";
//
//$string = preg_replace($patterns, $replacements, $string);
//
//echo $string;

//
//$string = "/123";
//
//$pattern = "/\/(\d+)/";
//
//$string = preg_match($pattern, $string);
//
//echo $string;



//$pattern = "/\{[a-zA-Z]+\}/";
//$string = "/time";
//
//$match = NULL;
//
//echo preg_match_all($pattern, $string, $match);
//
//foreach($match as $k1 => $v1){
//    echo "$k1 =><br>";
//    foreach($v1 as $k2 => $v2) {
//        echo " -- $k2 => $v2<br>";
//    }
//}

