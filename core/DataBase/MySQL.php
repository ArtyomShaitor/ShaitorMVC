<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 17.12.2014
 * Time: 9:06
 */

require_once "system/IDataBase.php";
require_once "system/Entity.php";

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
        try {
            $xml = simplexml_load_file("core/DataBase/database-settings/settings.xml");
            $json = json_encode($xml);
            $array = json_decode($json, true);
            $host = $array["param"][0];
            $login = $array["param"][1];
            $password = $array["param"][2];
            if (gettype($password) == "array") $password = "";
            if ($this->mysql_server = mysql_connect($host, $login, $password)) {
                if ($this->db = mysql_select_db($db_name, $this->mysql_server)) {
                    $this->setStatus(true, "You have been conntected to MySQL database!");
                } else {
                    $this->setStatus(false, "You haven't been connected to MySQL database.\n Error : there is no database with these host, login and password\n");
                }
            }

        }catch(Exception $e){
            die($e->getMessage());
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
        if($this->status == true) {
            $classname = get_class($entry);
            $array = (array)$entry;
            foreach ($array as $k => $v) {
                if (getType($v) == "string") {
                    $array[$k] = "'" . $v . "'";
                }
                if ($v == NULL) {
                    $v = "''";
                    $array[$k] = $v;
                };
                $k = str_replace($classname, "", $k);
            }

            $arrayString = implode(",", $array);

            $query = "INSERT INTO `$classname` VALUES($arrayString)";
            mysql_query($query);
        }else echo $this->getStatus();
    }

    public function remove(Entity $entry){
        if($this->status == true) {
            $classname = get_class($entry);
            $id = $entry->getPrimaryKey();

            $query = "DESCRIBE `$classname`";
            $query = mysql_query($query);
            $PKname = NULL;
            foreach ($row = mysql_fetch_assoc($query) as $k => $v) {
                if ($row["Key"] == "PRI") {
                    $PKname = $row['Field'];
                    break;
                }
            }

            $query = "DELETE FROM `$classname` WHERE `$PKname`='$id'";
            mysql_query($query);
        }else echo $this->getStatus();
    }

    public function update(Entity $entry)
    {
        if($this->status == true) {
            $id = $entry->getPrimaryKey();
            $classname = get_class($entry);
            $array = (array)$entry;
            $newArray = array();
            foreach ($array as $k => $v) {
                $v = "'" . $v . "'";
                if ($v === NULL) {
                    $v = "''";
                };

                $_k = trim(str_replace($classname, "", $k));

                $newArray[$_k] = "`" . $_k . "`=" . $v;
            }

            $query = "DESCRIBE `$classname`";
            $query = mysql_query($query);
            $PKname = "";
            foreach ($row = mysql_fetch_assoc($query) as $k => $v) {
                if ($row["Key"] == "PRI") {
                    $PKname = $row['Field'];
                    break;
                }
            }

            unset($newArray[$PKname]);

            $arrayString = implode(",", $newArray);

            if ($id !== NULL) {
                $q = "UPDATE `$classname` SET $arrayString WHERE `$PKname`='$id'";
                mysql_query($q);
            } else die("There is no any entity with this id");
        }else echo $this->getStatus();
    }

    public function __construct()
    {
        $this->setStatus(false, "You not connected to database!\n");
    }

    public function query($query)
    {
        if($this->getStatus() == true) {
            return mysql_query($query);
        }else echo $this->getStatus();
    }

    /**
     * @param $vars
     * @return mixed object
     */
    public function getEntry($classname, $id){
        if($this->status == true) {
            if (get_parent_class($classname) == "Entity") {
                $query = mysql_query("DESCRIBE `$classname`");
                $PKname = NULL;
                foreach ($row = mysql_fetch_assoc($query) as $k => $v) {
                    if ($row["Key"] == "PRI") {
                        $PKname = $row['Field'];
                        break;
                    }
                }
                $query = $this->query("SELECT * FROM `$classname` WHERE `$PKname`='$id' LIMIT 1");
                $instance = $classname::getInstance(mysql_fetch_assoc($query));
                return $instance;
            } else return NULL;
        }else {
            echo $this->getStatus();
            return NULL;
        }
    }

    public function getListOfEntries($classname){
        if($this->status == true) {
            $list = array();
            if (get_parent_class($classname) == "Entity"){

                $query = $this->query("SELECT * FROM `$classname` LIMIT 1000");
                while($row = mysql_fetch_assoc($query)) {
                    $instance = $classname::getInstance($row);
                    $list[] = $instance;
                }
                return $list;
            }
        }else echo $this->getStatus();
    }
}