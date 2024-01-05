<?php
require __DIR__ . '/controller.php';

class AccountsController extends Controller {
    public function index() {
        require __DIR__ . '/../views/accounts/index.php';
    }
}
?>