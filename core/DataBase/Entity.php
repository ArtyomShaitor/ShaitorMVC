<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 18.12.2014
 * Time: 12:33
 */

abstract class Entity {
    public static $childrenList = array();
    abstract public function getPrimaryKey();
    abstract public function mainConstructor();
    public function __construct(){
        $this->mainConstructor();
        Entity::follow();
    }
    protected  function follow()
    {
        Entity::$childrenList[] = get_class($this);
    }

}