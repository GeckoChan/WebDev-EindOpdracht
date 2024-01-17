<?php
use app\services\FriendService;

class FriendsController{
    public function index(){

        if (isset($_SERVER['REQUEST_METHOD'])) {
            $friendService = new FriendService();
            $json = file_get_contents('php://input');
            $data = json_decode($json);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(!isset($data->account_id)) {
                    echo json_encode(null);
                    return;
                }

                $account_id = filter_var($data->account_id, FILTER_VALIDATE_INT);
                if ($account_id === false) {
                    echo json_encode(null);
                    return;
                }

                $friends = $friendService->getFriends($account_id);
                if ($friends){
                    echo json_encode($friends);
                } else {
                    echo json_encode(null);
                }
            } 

            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                if(!isset($data->target_account_id, $data->current_account_id)) {
                    echo json_encode(null);
                    return;
                }

                $account1_id = filter_var($data->current_account_id, FILTER_VALIDATE_INT);
                $account2_id = filter_var($data->target_account_id, FILTER_VALIDATE_INT);
                if ($account1_id === false || $account2_id === false) {
                    echo json_encode('test2');
                    return;
                }

                $result = $friendService->removeFriend($account1_id, $account2_id);
                if($result){
                    echo json_encode($result);
                }else{
                    echo json_encode('test3');
                }
            }
        }
    }
}


?>