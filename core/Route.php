<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 13.12.2014
 * Time: 8:47
 */


class Route {

    private $relationArray = array(
        "/hello" => array(
            "controller" => "MainController",
            "action"     => "getTime"
        ),
        "/time" => array(
            "controller" => "MainController",
            "action"     => "getTime"
        ),
        "/{number}" => array(
            "controller" => "MainController",
            "action"     => "getNumber",
            "number"     => 1
        )
    );

    public function __constructor(){

    }

    /**
     * Функция, возвращающее мне имя контроллера, метода, а также, возможно, параметров.
     * @param $URL запрашиваемый адрес
     * @return mixed массив
     */
    public function requestMap($URL){

        $patterns = array();
        $replacements = array();

        $replacements[0] = "[a-zA-Z]+";
        $replacements[1] = "(\d+)";

        $patterns[0] = "/{string}/";
        $patterns[1] = "/{number}/";

        $pregRelationURL = "";

        $match = NULL;

        foreach($this->relationArray as $k => $v) {
            $temp_k = str_replace("/", "\/", $k);
            $pregRelationURL = "/^".preg_replace($patterns, $replacements, $temp_k)."$/";
                if ( preg_match($pregRelationURL, $URL, $match) > 0 ){
                    echo $k;
                    foreach($match as $_k1 => $_v1){
    //                    echo "$_k1 => $_v1<br>";
    //                    foreach($_v1 as $_k2 => $_v2) {
    //                        echo " -- $_k2 => $_v2<br>";
    //                    }
                    }
                break;
            }
        }

        $relation = NULL;

        return $relation;
    }

}