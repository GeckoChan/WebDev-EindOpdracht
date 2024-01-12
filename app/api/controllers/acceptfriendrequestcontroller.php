<?php
use app\services\FriendService;
use app\services\AccountService;

class AcceptFriendRequestController {

    // var data = {
    //     target_account_id: account_id,
    //     current_account_id: globalAccount.account_id
    // };

    public function index(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $friendService = new FriendService();

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            $account1_id = $data->current_account_id;
            $account2_id = $data->target_account_id;
            
            $result = $friendService->acceptFriendRequest($account1_id, $account2_id);
            if($result){
                echo json_encode($result);
            }else{
                echo json_encode(null);
            }
        }
    }
}

?>