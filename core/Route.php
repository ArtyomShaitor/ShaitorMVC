<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 13.12.2014
 * Time: 8:47
 */


class Route {

//    private $relationArray = array(
//        "/{number}" => array(
//            "controller" => "MainController",
//            "action"     => "getNumber",
//            "number"     => 1
//        ),
//        "/{number}/{string}" => array(
//            "controller" => "MainController",
//            "action"     => "getNumber",
//            "age"        => 1,
//            "name"       => 2
//        )
//    );

    private $relationArray = array();

    public function __construct(){
        $file = file_get_contents("relations.json");
        $this->relationArray = json_decode($file, true);

    }

    /**
     * Функция, возвращающее мне имя контроллера, метода, а также, возможно, параметров.
     * @param $URL запрашиваемый адрес
     * @return mixed массив
     */
    public function requestMap($URL){

        try {
            if (substr($URL, -1) == "/") $URL = substr($URL, 0, strlen($URL) - 1);

            $patterns = array();
            $replacements = array();

            $replacements[0] = "([a-zA-Z]+)";
            $replacements[1] = "(\d+)";

            $patterns[0] = "/{string}/";
            $patterns[1] = "/{number}/";

            $pregRelationURL = "";

            $relation = NULL;
            $match = NULL;

            foreach ($this->relationArray as $k => $v) {
                $temp_k = str_replace("/", "\/", $k);
                $pregRelationURL = "/^" . preg_replace($patterns, $replacements, $temp_k) . "$/";
                if (preg_match($pregRelationURL, $URL, $match) > 0) {
                    $i = 0;
                    foreach ($v as $key => $param) {
                        if($i > 1){
                            $relation["params"][$key] = $match[$param];
                        }
                        $i++;
                    };
                    $relation["controller"] = $this->relationArray[$k]["controller"];
                    $relation["action"] = $this->relationArray[$k]["action"];

                    $relation['errors'] = false;
                    break;
                }
            }

            if ($relation == NULL) $relation["errors"] = true;

            return $relation;
        } catch (Exception $e){
            echo "Exception : \n -Code:".$e->getCode()."\n Message:".$e->getMessage();
        }
    }

    public function toErrorPage($code){
        include_once "errors/".$code.".html";
        die();
    }

}