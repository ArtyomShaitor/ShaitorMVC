<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 13.12.2014
 * Time: 15:38
 */


class View {
    private $pageURL;
    private $params;
    public $model;

    public function setPageURL($URL){
        $this->pageURL = $URL;
    }
    public function getPageURL(){
        return $this->pageURL;
    }
    public function setParams($params){ $this->params = $params; }
    public function getParams(){ return $this->params; }

    public function __construct($pageURL, $model, $params = NULL){
        $this->pageURL = $pageURL;
        $this->params = $params;
        $this->model = $model;
        if(empty($pageURL)) $this->pageURL = NULL;
        if(empty($model)) $this->model = NULL;
    }

    public function Start(){
        if($this->pageURL == NULL){
            die("View page is not defined");
        }
        return include "views/".$this->pageURL;
    }

    public function addModel($model){
        $this->model = $model;
    }

} 