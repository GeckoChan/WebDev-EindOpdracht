<?php

class LogoutController{
    public function index(){
        unset($_SESSION['account_id']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['email']);
    }
}

?>