<?php

require_once "core/Controller.php";
require_once "core/View.php";
require_once "core/Model.php";

class MainController extends Controller{

    public function getTime(){

        $view = new View("timepage.php", NULL);
        return $view;
    }

    public function getName($params){
        $model = new Model();
        $model->setAttribute("name", $params["name"]);
        $model->setAttribute("title", "Hello!");
        $model->setAttribute("message", "...");
        $view = new View("test.php",$model);
        return $view;
    }

    public function getNameAndMessage($params){
        $model = new Model();
        $model->setDefAttr("name",$params);
        $model->setDefAttr("message",$params);
        $model->setAttribute("title", "Hello, ".$params["name"]);
        $view = new View("test.php", $model);
        return $view;
    }

    public function adminPage(){
        return new View("admin.php", new Model());
    }

} 