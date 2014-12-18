<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 17.12.2014
 * Time: 9:04
 */

require_once "Entity.php";

interface IDataBase {
    public function connect($db_name);
    public function disconnect();

    public function getStatus();

    public function save(Entity $entry);
    public function remove(Entity $entry);
    public function update(Entity $entry);

    public function __construct();
}