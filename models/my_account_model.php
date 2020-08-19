<?php/** * Created by PhpStorm. * User: aaron * Date: 09/12/2015 * Time: 11:57 */class My_Account_Model extends Model{    function __construct()    {        parent::__construct();    }    function get_user()    {        $id = Session::get('loggedIn');        $prepareDB = $this->prepareDB->prepare("SELECT * FROM userstb WHERE id = :id");        $prepareDB->execute(array(':id' => $id));        $data = $prepareDB->fetch();        return $data;    }    function update_email($controller)    {        $oldEmail = @$_POST['oldEmail'];        $newEmail = @$_POST['newEmail'];        $confirmEmail = @$_POST['confirmEmail'];        $id = Session::get('loggedIn');        if ($newEmail === $confirmEmail) {            $prepareDB = $this->prepareDB->prepare("UPDATE userstb SET email = :newEmail WHERE id = :id AND email = :oldEmail");            $prepareDB->execute(array(':newEmail' => $newEmail, ':id' => $id, ':oldEmail' => $oldEmail));            $errorCode = $prepareDB->errorCode();            if ($prepareDB->rowCount() == 1) {                if ($errorCode == "00000") {                    $controller->view->emailmsgSuccess = "Success All Updated!";                    $controller->view->render("my_account/index");                }            } elseif ($errorCode == "23000") {                $controller->view->emailmsgFailure = "Error - A User with this email address has already registered.";                $controller->view->render("my_account/index");            } else {                $controller->view->emailmsgFailure = "Error - email not found";                $controller->view->render("my_account/index");            }        } else {            $controller->view->emailmsgFailure = "New Emails Do Not Match";            $controller->view->render("my_account/index");        }    }    function update_password($controller)    {        $oldPassword = @$_POST['oldPassword'];        $newPassword = @$_POST['newPassword'];        $confirmPassword = @$_POST['confirmPassword'];        $id = Session::get('loggedIn');        if ($newPassword === $confirmPassword) {            $prepareDB = $this->prepareDB->prepare("UPDATE userstb SET password = MD5(:newPassword) WHERE id = :id AND password = MD5(:oldPassword)");            $prepareDB->execute(array(':newPassword' => $newPassword, ':id' => $id, ':oldPassword' => $oldPassword));            $errorCode = $prepareDB->errorCode();            if ($prepareDB->rowCount() == 1) {                if ($errorCode == "00000") {                    $controller->view->passwordmsgSuccess = "Success All Updated!";                    $controller->view->render("my_account/index");                }            } else {                $controller->view->passwordmsgFailure = "Error - Old Password Incorrect";                $controller->view->render("my_account/index");            }        } else {            $controller->view->passwordmsgFailure = "New Passwords Do Not Match";            $controller->view->render("my_account/index");        }    }    function savePicture($id, $ext) {        if (!empty($id) && !empty($ext)) {            $pictureURL = $id . $ext;            $prepareDB = $this->prepareDB->prepare("UPDATE userstb SET picture = :pictureURL WHERE id = :id");            $prepareDB->execute(array(':pictureURL' => $pictureURL, ':id' => $id));        }    }    function deleteAccount() {        $id = Session::get('loggedIn');        $prepareDB = $this->prepareDB->prepare("DELETE FROM userstb WHERE id = :id");        $prepareDB->execute(array(':id' => $id));}    }