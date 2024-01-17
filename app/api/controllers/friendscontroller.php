<?php
use app\services\FriendService;

class FriendsController{
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $friendService = new FriendService();
            $json = file_get_contents('php://input');
            $data = json_decode($json);

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
    }
}


?>