<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 17.12.2014
 * Time: 9:06
 */

require_once "IDataBase.php";
require_once "core/DataBase/Entity.php";

class MySQL implements IDataBase{

    private $status;
    private $status_message;
    private $mysql_server;
    private $db;

    private function setStatus($status, $status_message){
        $this->status = $status;
        $this->status_message = $status_message;
    }

    public function connect($db_name)
    {
        $xml = simplexml_load_file("core/DataBase/database-settings/settings.xml");
        $json = json_encode($xml);
        $array = json_decode($json,true);
        $host = $array["param"][0];
        $login = $array["param"][1];
        $password = $array["param"][2];
        if (gettype($password) == "array") $password = "";

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

    public function save(Entity $entry)
    {
        $classname = get_class($entry);
        $array = (array) $entry;
        foreach($array as $k => $v){
            if (getType($v)=="string") {
                $array[$k] = "'".$v."'";
            }
            if ($v == NULL) {
                $v = "''";
                $array[$k] = $v;
            };
            $k = str_replace($classname, "", $k);
        }

        $arrayString =  implode(",", $array);

        $query = "INSERT INTO `$classname` VALUES($arrayString)";
        mysql_query($query);
    }

    public function remove(Entity $entry){
        $classname = get_class($entry);
        $id = $entry->getPrimaryKey();

        $query = "DESCRIBE `$classname`";
        $query = mysql_query($query);
        $PKname = NULL;
        foreach($row = mysql_fetch_assoc($query) as $k => $v){
            if($row["Key"] == "PRI"){
                $PKname = $row['Field'];
                break;
            }
        }

        $query = "DELETE FROM `$classname` WHERE `$PKname`='$id'";
        mysql_query($query);
    }

    public function update(Entity $entry)
    {
//        $entry =
        echo Entity::$childrenList[0];
        
        // TODO: Implement update() method.
    }

    public function __construct()
    {
        $this->setStatus(false, "You not connected to database!\n");
        // TODO: Implement __construct() method.
    }

}