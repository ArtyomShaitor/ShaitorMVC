<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 18.12.2014
 * Time: 12:33
 */

require_once"core/DataBase/MySQL.php";
require_once "core/DataBase/IDataBase.php";

abstract class Entity {
    public static $childrenList = array();
    abstract public function getPrimaryKey();

    /**
     * @param $vars
     * @return Entity object
     */
    abstract static public function getInstance($vars);


}