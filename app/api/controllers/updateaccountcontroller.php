<?php
use app\services\AccountService;
use app\models\Account;

class UpdateAccountController {
    public function index() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accountService = new AccountService();
            $json = file_get_contents('php://input');
            $data = json_decode($json);

            if(!isset($data->account_id, $data->username, $data->email, $data->password1, $data->password2)) {
                echo json_encode(null);
                return;
            }

            $username = htmlspecialchars($data->username, ENT_QUOTES, 'UTF-8');
            $email = filter_var($data->email, FILTER_SANITIZE_EMAIL);

            if($data->password1 != $data->password2) {
                echo json_encode(null);
                return;
            }

            $account = new Account();
            $account->setAccountId($data->account_id);
            $account->setUsername($username);
            $account->setEmail($email);
            $account->setPassword($data->password1);
            $response = $accountService->updateAccount($account);
            if($response) {
                $_SESSION['account_id'] = $account->getAccountId();
                $_SESSION['username'] = $account->getUsername();
                $_SESSION['email'] = $account->getEmail();
                echo json_encode($response);
            } else {
                echo json_encode(null);
            }
        }
    }
}


