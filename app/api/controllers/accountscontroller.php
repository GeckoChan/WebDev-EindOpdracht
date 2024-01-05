<?php
use app\services\AccountService;

class AccountsController {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $accountService = new AccountService();
            $accounts = $accountService->getAll();
            if ($accounts){
                echo json_encode($accounts);
            } else {
                echo json_encode(null);
            }
        } 
    }
}

?>