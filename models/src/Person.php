<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 18.12.2014
 * Time: 11:48
 */

require_once "core/DataBase/system/Entity.php";


class Person extends Entity{

    private $id;
    private $name;
    private $surname;

    public function __construct($name = NULL, $surname = NULL){
        $this->id = NULL;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getId(){return $this->id;}
    public function getName(){return $this->name;}
    public function getSurname(){return $this->surname;}

    private function setId($id){ $this->id = $id; }
    public function setName($name){ $this->name = $name; }
    public function setSurname($surname){ $this->surname = $surname; }


    public function getPrimaryKey()
    {
        return $this->id;
    }


    static public function getInstance($vars)
    {
        $id = $vars["id"];
        $name = $vars["name"];
        $surname = $vars["surname"];
        $obj = new Person($name, $surname);
        $obj->setId($id);
        return $obj;
    }

}