<?php
/**
 * Created by PhpStorm.
 * User: Artyom
 * Date: 17.12.2014
 * Time: 9:04
 */

require_once "Entity.php";

interface IDataBase {
    /**
     * Подключение к базе данных. Параметры входа берутся из файла
     * @param string $db_name имя базы данных
     */
    public function connect($db_name);

    /**
     * Отключение от базы данных
     */
    public function disconnect();

    /**
     * Статус соединения с базой данных
     * @return string сообщение
     */
    public function getStatus();

    /**
     * Сохранение объекта $entry в таблицу
     * @param Entity $entry объект
     */
    public function save(Entity $entry);

    /**
     * Удаление объекта $entry из таблицы
     * @param Entity $entry объект
     */
    public function remove(Entity $entry);

    /**
     * Обновление объекта $entry в таблице
     * @param Entity $entry объект
     */
    public function update(Entity $entry);

    /**
     * Отправление запроса в базу данных
     * @param string $query запрос
     * @return mixed
     */
    public function query($query);

    public function getEntry($classname, $id);

    public function getListOfEntries($classname);


    public function __construct();
}