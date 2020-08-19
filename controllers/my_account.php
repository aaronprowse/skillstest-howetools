<?php

/**
 * Created by PhpStorm.
 * User: aaron
 * Date: 05/12/2015
 * Time: 23:03
 */
class my_Account extends Controller
{

    function __construct()
    {
        $this->restricted = true;
        parent::__construct();
//        Session::init();
//        $logged = Session::get('loggedIn');
//        if ($logged == false) {
//            Session::destroy();
//            header('location: ../index');
//            exit;
//        }

        $this->view->js[] = to_url('views/my_account/js/default.js');
        $this->view->parent = "my_account";
    }

    function index()
    {
        $this->run();
        $this->uploadPicture();
        $this->view->render('my_account/index');
    }

    function uploadPicture() {
        if(isset($_POST['uploadBtn'])) {
            $filetmp = $_FILES["pictureUpload"]["tmp_name"];
            $path = $_FILES['pictureUpload']['name'];
            $ext = '.' . pathinfo($path, PATHINFO_EXTENSION);
            $targetDir = "public/images/Users/profilepictures/";
            $userID = $_POST['userID'];
            $uploadCode = 1;

            //Check if real image & image size
            $checkImage = getimagesize($filetmp);

            if($checkImage !== false) {
                $uploadCode = 1;
            } else {
                $this->view->pictureMSGFailure = "Error - File is not an image";
                $uploadCode = 0;
            }

            if ($_FILES['pictureUpload']['size'] > 2000000) {
                $this->view->pictureMSGFailure = "Error - Image is too large";
                $uploadCode = 0;
            }

            //check if correct file format
            if($ext != ".jpg" && $ext != ".JPG" && $ext != ".png" && $ext != ".PNG" && $ext != ".jpeg" && $ext != ".JPEG" && $ext != ".gif" && $ext != ".GIF") {
                $this->view->pictureMSGFailure = "Error - This upload only allows for jpg/jpeg, png & gif";
                $uploadCode = 0;
            }

            if($uploadCode == 1) {
                move_uploaded_file($filetmp, $targetDir.$userID.$ext);
                $this->model->savePicture($userID, $ext);
                $this->picture($this->model->get_user());
                $this->view->pictureMSGSuccess = "Success - Image Uploaded";
            }
        }
        return 0;
    }

    function run() {
        $this->view->user = $this->model->get_user();
        $this->view->picture = $this->picture($this->view->user);
    }

    function picture($user) {
        if (empty($user['picture'])) {
            return "default-user.png";
        } else {
            return "profilepictures/" . $user['picture'];
        }
    }

    function bio() {
        $this->run();
        $this->model->update_bio($this);
    }


    function email() {
            $this->run();
            $this->model->update_email($this);
    }

    function password() {
            $this->run();
            $this->model->update_password($this);
    }

    function deleteAccount() {
        $this->model->deleteAccount($this);
        $this->logout();
    }

    function logout()
    {
        Session::destroy();
        $this->view->render('logout/index');
        header('my_account/logout');
        exit;
    }
}