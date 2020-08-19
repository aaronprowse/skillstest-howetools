<?php
/**
 * Created by PhpStorm.
 * User: aaron
 * Date: 04/12/2015
 * Time: 16:19
 */
class Database extends pdo
{
    public function __construct()
    {
        try {
            //parent::__construct('mysql:host=localhost;dbname=onlinepropertytrainer;charset=utf8', 'root', '');
            parent::__construct(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}