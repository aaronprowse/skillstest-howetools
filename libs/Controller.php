<?php
/**
 * Created by PhpStorm.
 * User: aaron
 * Date: 04/12/2015
 * Time: 11:35
 */

class Controller {

    public $model;
    protected $restricted = false;

    function __construct() {
        $this->loadFunctions();
        //echo 'Main Controller <br />';
        $this->view = new View();
        $this->checkUser();
    }

    private function checkUser() {
        Session::init();
        if ($this->restricted && !Session::get('loggedIn')) {
            $this->view->render('index/index');
            exit;
        }
    }

    public function loadModel($name) {

        $path = 'models/' . $name . '_model.php';

        if (file_exists($path)) {
            require 'models/' . $name . '_model.php';

            $modelName = $name . '_model';
            $this->model = new $modelName();
        }
    }

    private function loadFunctions() {
        if(!function_exists("to_url")) {
            function to_url($url)
            {
                $url = str_replace("/", DIRECTORY_SEPARATOR, str_replace("\\", DIRECTORY_SEPARATOR, $url));

                return $url;
            }
        }
    }
}