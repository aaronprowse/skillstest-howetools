<?php
/**
 * Created by PhpStorm.
 * User: aaron
 * Date: 04/12/2015
 * Time: 11:48
 */

class Model {

    function __construct() {
        $this->prepareDB = new Database();
        $this->errorCode = 0;
        $this->errorMessages = array(
            23101 => "Email has already been registered on this website.",
            23117 => "Username has already been registered on this website.",
            1 => "Passwords do NOT match",
            2 => "Username contains a space"
        );
    }
}