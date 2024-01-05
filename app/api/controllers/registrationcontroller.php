<?php
use app\services\AccountService;
use app\models\Account;
class Registrationcontroller {
    public function index() {

        $accountService = new AccountService();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            
            $username = $data->username;
            $email = $data->email;
            $password1 = $data->password1;
            $password2 = $data->password2;
            
            if($password1 == $password2){
                $account = $accountService->checkIfExist($username, $password1);
                if($account){
                    // if accounts exists do not insert
                    echo json_encode(null);
                }else{
                    $account = new Account();
                    $account->setUsername($username);
                    $account->setEmail($email);
                    $account->setPassword($password1);
                    $accountService->insert($account);
                    echo json_encode($account);
                }
            }else{
                // if password1 and 2 aren't the same do not insert
                echo json_encode(null);
            }
        }
    }
}

?>