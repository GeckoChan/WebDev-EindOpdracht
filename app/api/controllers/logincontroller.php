<?php
use app\services\AccountService;
class LoginController {
    // login handler api
    
    public function index() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $accountService = new AccountService();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            
            if (!isset($data->username, $data->password)) {
                echo json_encode(null);
                return;
            }
            $username = htmlspecialchars($data->username, ENT_QUOTES, 'UTF-8');
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