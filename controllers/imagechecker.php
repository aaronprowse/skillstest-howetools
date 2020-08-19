<?php

class Imagechecker extends Controller
{

    function __construct()
    {
        $this->restricted = true;
        parent::__construct();
        Session::init();
        $logged = Session::get('loggedIn');

        if ($logged == false) {
            Session::destroy();
            header('location: ../index');
            exit;
        }

        $this->view->parent = "imagechecker";
    }

    function index()
    {
        if (!Session::get('loggedIn')) {
            $this->view->render('index');
        } else {
            $this->view->render('imagechecker/index');
        }
    }

    function runChecker()
    {
        $this->model->getImages($this);
    }

    function updateRecord()
    {
        if (isset($_POST['update'])) {
            if (!empty($_FILES['newImage']['name'])) {
                    $this->model->recordDelete($this);
                    $this->uploadPicture();
                } else {
                $this->view->pictureMSGFailure =  "Error - Image failed to upload please select a new image and attempt again.";
            }
        } else {
            $this->model->recordDelete($this);
        }

        $this->runChecker($this);
    }

    function uploadPicture() {
            $uploadDir = "images/";
            $uploadFile = $uploadDir . basename($_FILES['newImage']['name']);
            $uploadCode = 1;
            $uploadType = strtolower(pathinfo($uploadFile,PATHINFO_EXTENSION));

        if (file_exists($uploadFile)) {
            $this->view->pictureMSGFailure = "Error - File Already Exists";
            $uploadCode = 0;
        }

        if ($_FILES['newImage']['size'] > 2000000) {
            $this->view->pictureMSGFailure = "Error - Image is too large";
            $uploadCode = 0;
        }

        //check if correct file format
        if($uploadType != "jpg") {
            $this->view->pictureMSGFailure = "Error - This upload only allows for jpg";
            $uploadCode = 0;
        }

        if($uploadCode == 1) {
            if (move_uploaded_file($_FILES["newImage"]["tmp_name"], $uploadFile)) {
                $this->model->savePicture(basename($_FILES['newImage']['name']), $_POST['sku'], $_POST['fileName']);
                $this->view->pictureMSGSuccess = "Success - " . basename( $_FILES["newImage"]["name"]) . " Image has been Uploaded";
            }
        }

    }

}
