<?php

require_once "settings.php";

class RequestMapper {

    /**
     * ------- FIELDS --------------------------------------------------------------------------------------------------
     */

    private $relationArray = array();
    private $cuts = array();


    /**
     * ------- CONSTRUCTORS ---------------------------------------------------------------------------------------------
     */

    public function __construct(){
        $this->readRelationsFromDir();
    }


    /**
     * ------- GETTERS / SETTERS ---------------------------------------------------------------------------------------
     */

    public function setCuts($cuts, $request_url){
        $this->cuts = $cuts;

    }






    /**
     * ------- PRIVATE METHODS -----------------------------------------------------------------------------------------
     */

    /**
     * Функция, читающая файлы relations в поле $relationArray
     */
    private function readRelationsFromDir(){
        $array = array();
        if( is_dir(RELATIONS_FOLDER) ){
            $files = glob(RELATIONS_FOLDER."/*.json");
            if( count($files) == 0 ) die ("There are no any relation files in folder");
            foreach($files as $k => $v){
                $file = file_get_contents($v);
                $array = json_decode($file, true);
                if (count($array) == 0) {
                    continue;
                }
                foreach($array as $k1 => $v1){
                    $this->relationArray[$k1] = $v1;
                }
            }
        }else die(RELATIONS_FOLDER." is not a relation folder");
    }

    /**
     * Функция, возвращающее имя контроллера, метода, а также параметров.
     * @param $URL запрашиваемый адрес
     * @return relation массив
     */






    /**
     * ------- PUBLIC METHODS ------------------------------------------------------------------------------------------
     */


    public function refactorURL($request_url){
        if ($this->cuts == NULL) return $request_url;
        foreach($this->cuts as $k => $v) {
            if (strpos($request_url, $v) != NULL) {
                $pos = strpos($request_url, $v);
                $request_url = substr($request_url, 0, $pos);
            }
        }
        return $request_url;
    }

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