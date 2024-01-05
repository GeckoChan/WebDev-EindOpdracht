<?php

class Logoutcontroller{
    public function index(){
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['email']);
    }
}

?>