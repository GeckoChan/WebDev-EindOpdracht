<?php
use app\services\AccountService;
use app\models\Account;

class DeleteAccountController {
    public function index() {
        if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

            $accountService = new AccountService();
            $account_id = $_SESSION['account_id'];
            if ($accountService->remove($account_id)){
                unset($_SESSION['account_id']);
                unset($_SESSION['username']);
                unset($_SESSION['email']);

                echo json_encode(true);
            } else {
                echo json_encode(null);
            }
        }
    }
}
