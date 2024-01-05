<?php
use app\services\AccountService;
class LoginController {
    // login handler api
    
    public function index() {
        // check if a session is already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $accountService = new AccountService();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            $username = $data->username;
            $password = $data->password;
            $account = $accountService->checkIfExist($username, $password);
            if($account){
                $_SESSION['account_id'] = $account->getAccountId();
                $_SESSION['username'] = $account->getUsername();
                $_SESSION['email'] = $account->getEmail();
                echo json_encode($account);
            }else{
                echo json_encode(null);
            }
        }
    }
}
?>