<?php

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