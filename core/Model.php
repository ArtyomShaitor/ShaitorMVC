<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 13.12.2014
 * Time: 16:35
 */

class Model {
    private $array = array();

    public function __construct(){

    }

    public function setAttribute($key, $value){
        $this->array[$key] = $value;
    }

    public function setDefAttr($key, $params){
        $this->array[$key] = $params[$key];
    }

    public function getAttribute($key){
        if($this->array[$key] != NULL)
        return $this->array[$key];
        else return NULL;
    }

} 