<?php
require __DIR__ . '/controller.php';

class AccountController extends Controller {
    public function index() {
        require __DIR__ . '/../views/account/index.php';
    }
}
?>