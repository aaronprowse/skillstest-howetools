<?php
/**
 * Created by PhpStorm.
 * User: aaron
 * Date: 09/12/2015
 * Time: 10:22
 */

class Session
{
    public static function init()
    {
        @session_start();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    }

    public static function destroy()
    {
        session_destroy();
    }

}
