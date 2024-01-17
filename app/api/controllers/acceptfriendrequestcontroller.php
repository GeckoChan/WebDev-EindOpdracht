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

            if (!isset($data->current_account_id, $data->target_account_id)) {
                echo json_encode(null);
                return;
            }

            $account1_id = filter_var($data->current_account_id, FILTER_VALIDATE_INT);
            $account2_id = filter_var($data->target_account_id, FILTER_VALIDATE_INT);

            if ($account1_id === false || $account2_id === false) {
                // One or both of the IDs were not valid numbers
                echo json_encode(null);
                return;
            }
            
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