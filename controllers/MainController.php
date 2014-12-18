<?php

require_once "core/MVCClasses/IController.php";
require_once "core/MVCClasses/View.php";
require_once "core/MVCClasses/Model.php";
require_once "core/DataBase/MySQL.php";

require_once "models/src/Person.php";

class MainController implements  IController{

    private $database;



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



    public function __construct()
    {
        $this->database = new MySQL();
        $this->database->connect("shaitormvc_db");
        $person = new Person("Artyom", "Shaitor");
        $person->setId(5);
//        $person->setName("Artyom");
        $this->database->update($person);
    }


}