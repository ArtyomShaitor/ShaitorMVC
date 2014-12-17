<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 17.12.2014
 * Time: 9:06
 */

require_once "IDataBase.php";

class MySQL implements IDataBase{

    private $status;
    private $status_message;
    private $mysql_server;
    private $db;

    private function setStatus($status, $status_message){
        $this->status = $status;
        $this->status_message = $status_message;
    }

    public function connect($host, $login, $password, $db_name)
    {
        if($this->mysql_server = mysql_connect($host, $login, $password)){
            if($this->db = mysql_select_db($db_name, $this->mysql_server)){
                $this->setStatus(true, "You have been conntected to MySQL database!");
            }
            else{
                $this->setStatus(false, "You haven't been connected to MySQL database.\n Error : there is no database with this name\n");
            }
        }
        else{
            $this->setStatus(false, "You haven't been connected to MySQL database.\n Error : there is no database with these host, login and password\n");
        }

    }

    public function disconnect()
    {
        mysql_close($this->mysql_server);
    }

    public function getStatus()
    {
        return $this->status_message;
    }

    public function save($entry)
    {
        // TODO: Implement save() method.
    }

    public function __construct()
    {
        $this->setStatus(false, "You not connected to database!\n");
        // TODO: Implement __construct() method.
    }
}