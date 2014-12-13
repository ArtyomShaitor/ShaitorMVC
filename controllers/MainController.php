<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 13.12.2014
 * Time: 9:26
 */

require_once "IController.php";

class MainController implements IController {

    /**
     * getTime();
     * @returns page
     */
    public function getTime(){
        return "timepage.php";
    }

    public function getNumber(){
        return "numberpage.php";
    }

} 