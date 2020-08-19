<?php
/**
 * Created by PhpStorm.
 * User: aaron
 * Date: 04/12/2015
 * Time: 11:40
 */

Class View {

    public $parent;

    function __construct()
    {
        //Global JavaScript
        $this->js = array(
            to_url('public/js/jquery.min.js'),
            to_url('public/assets/bootstrap/bootstrap.min.js'),
            to_url('public/js/custom.js')
        );
    }

    public function render($name, $noInclude = false) {
        if($noInclude == true) {
            require 'views/' . $name . '.php';
        } else {
        require 'views/header.php';
        require 'views/' . $name . '.php';
        require 'views/footer.php';
        }
    }
}