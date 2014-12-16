<?php

class Model {
    private $array = array();

    /**
     * @return Model
     */
    public function __construct(){

    }

    /**
     * Установка аттрибута
     * @param $key ключ
     * @param $value значение
     */
    public function setAttribute($key, $value){
        $this->array[$key] = $value;
    }

    /**
     * Установка аттрибута, если ключи одинаковые
     * @param $key ключ
     * @param $params значение
     */
    public function setDefAttr($key, $params){
        $this->array[$key] = $params[$key];
    }

    /**
     * Получение аттрибута
     * @param $key ключ
     * @return object
     */
    public function getAttribute($key){
        if($this->array[$key] != NULL)
        return $this->array[$key];
        else return NULL;
    }

} 