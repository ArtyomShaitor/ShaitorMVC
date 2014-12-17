<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 17.12.2014
 * Time: 9:04
 */

interface IDataBase {
    public function connect($host, $login, $password, $db_name);
    public function disconnect();
    public function getStatus();
    public function save($entry);
    public function __construct();
}