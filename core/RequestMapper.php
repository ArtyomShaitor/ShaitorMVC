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


    private function selectAllKeysByPattern($pattern){
        $array = array();
        foreach($this->relationArray as $k => $v){
            if( strpos($k, $pattern) === 0 ) {
                $array[$k] = $v;
            }
        }
        return $array;
    }

    /**
     * Получает relation object из url'a, содержащего параметры
     * @var Boolean
     * @param $URL string URL
     * @param array $patterns
     * @param array $replacements
     * @param object $relation исходный relation object
     * @return void
     */
    private function getRelationFromParamsURL($URL, &$patterns, &$replacements, &$relation)
    {
        $array = $this->selectAllKeysByPattern("*");
        $flag = false;
        if(count($array) > 0) {
            foreach ($array as $k => $v) {
                $temp_k = str_replace("*", "", $k);
                $URL_length = strlen($URL);
                $tail_length = strlen($temp_k);
                if (strpos($URL, $temp_k) == $URL_length - $tail_length && gettype(strpos($URL, $temp_k))== "integer" ) {
                    $relation["controller"] = $this->relationArray[$k]["controller"];
                    $relation["action"] = $this->relationArray[$k]["action"];
                    $relation['errors'] = false;
                    $flag = true;
                    break;
                }
            }
        }
        if(!$flag) {
            foreach ($this->relationArray as $k => $v) {
                if (strpos($k, "*") != NULL) {
                    $temp_k = str_replace("*", "", $k);
                    $URL_length = strlen($URL);
                    $tail_length = strlen($temp_k);
                    if (strpos($URL, $temp_k) == $URL_length - $tail_length) {
                        $relation["controller"] = $this->relationArray[$k]["controller"];
                        $relation["action"] = $this->relationArray[$k]["action"];

                        $relation['errors'] = false;
                        break;
                    }
                } else {
                    $temp_k = str_replace("/", "\/", $k);
                    $pregRelationURL = "/^" . preg_replace($patterns, $replacements, $temp_k) . "$/";
                    if (preg_match($pregRelationURL, $URL, $match) > 0) {
                        $i = 0;
                        foreach ($v as $key => $param) {
                            if ($i > 1) {
                                $value = urldecode($match[$param]);
                                $relation["params"][$key] = $value;
                            }
                            $i++;
                        };
                        $relation["controller"] = $this->relationArray[$k]["controller"];
                        $relation["action"] = $this->relationArray[$k]["action"];

                        $relation['errors'] = false;
                        break;
                    }
                }

            }
        }

    }

    /**
     * Получает relation object из url'a без параметров
     * @param $URL string url
     * @param $relation object relation
     * @return void
     */
    private function getRelationFromURL($URL, &$relation){
        $relation["controller"] = $this->relationArray[$URL]["controller"];
        $relation["action"] = $this->relationArray[$URL]["action"];
        $relation['errors'] = false;
    }


    /**
     * Рефакторинг URL
     * @param $request_url исходный запрос
     * @return string переделанный запрос
     */
    private function refactorURL(&$URL, &$patterns, &$replacements){
        if ($this->cuts == NULL) return $URL;
        foreach($this->cuts as $k => $v) {
            if (strpos($URL, $v) != NULL) {
                $pos = strpos($URL, $v);
                $URL = substr($URL, 0, $pos);
            }
        }
        if (substr($URL, -1) == "/" && strlen($URL) != 1) $URL = substr($URL, 0, strlen($URL) - 1);
        $replacements[0] = "([a-zA-Z0-9,%.!:;'\"#]+)";
        $patterns[0] = "/{value}/";
        return $URL;
    }






    /**
     * ------- PUBLIC METHODS ------------------------------------------------------------------------------------------
     */

    public function requestMap($URL){
        try {
            $patterns = array();
            $replacements = array();

            $this->refactorURL($URL, $patterns, $replacements);

            $relation = NULL;
            $match = NULL;
            if($this->relationArray[$URL] != NULL){
                $this->getRelationFromURL($URL, $relation);
            }
            else {
                $this->getRelationFromParamsURL($URL, $patterns, $replacements, $relation);
            }
            if ($relation == NULL) $relation["errors"] = true;
            return $relation;
        } catch (Exception $e){
            echo "Exception : \n -Code:".$e->getCode()."\n Message:".$e->getMessage();
            return false;
        }
    }

    public function toErrorPage($code){
        include_once "errors/".$code.".html";
        die();
    }

}