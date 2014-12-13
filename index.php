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

//$controller_name = $relation['controller'];
//$action_name = $relation['action'];
//
//include_once "controllers/".$controller_name.".php";
//
//$controller = new $controller_name();
//$action = $controller->$action_name();
//
//include_once "views/".$action;






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

