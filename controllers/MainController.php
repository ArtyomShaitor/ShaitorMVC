<?php

class MainController {

    public function getTime(){

        $view = new View("timepage.php", NULL);
        return $view;
    }

    public function getNumber($params){
        $model = new Model();
        $model->setAttribute("number", $params["number"]);
        $view = new View("test.php",$model);
        return $view;
    }

    public function getNumberAndString($params){
        $model = new Model();
        $model->setDefAttr("number",$params);
        $model->setDefAttr("name",$params);
        $view = new View("test.php", $model);
        return $view;
    }

} 