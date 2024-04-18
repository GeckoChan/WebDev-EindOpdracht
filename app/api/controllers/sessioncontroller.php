<?php
use app\models\Account;

class SessionController {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (session_status() == PHP_SESSION_NONE || !isset($_SESSION['account_id'])) {
                echo json_encode(null);
                return;
            }
            $account = new Account();
            $account->setAccountId($_SESSION['account_id']);
            $account->setUsername($_SESSION['username']);
        
            $account->setEmail($_SESSION['email']);
        
            echo json_encode($account);
        } 
    }
}


?>