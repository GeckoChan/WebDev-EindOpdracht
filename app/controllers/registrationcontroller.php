<?php
require __DIR__ . '/controller.php';

class RegistrationController extends \Controller {
    public function index() {
        require __DIR__ . '/../views/registration/index.php';
    }
}