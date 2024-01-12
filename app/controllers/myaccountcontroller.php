<?php
require __DIR__ . '/controller.php';

class MyAccountController extends Controller {
    public function index() {
        require __DIR__ . '/../views/myaccount/index.php';
    }
}
?>