<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 13.12.2014
 * Time: 9:26
 */


class MainController {

    /**
     * getTime();
     * @returns page
     */
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