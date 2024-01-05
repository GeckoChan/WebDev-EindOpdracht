<?php
use app\services\FriendService;
use app\models\Friend;

class AddFriendsController {
    private FriendService $friendService;
    public function index() {

        // send friend request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $friendService = new FriendService();

            $json = file_get_contents('php://input');
            $data = json_decode($json);
            $account1_id = $data->current_account_id; // account1_id is the person who sent the friend request
            $account2_id = $data->target_account_id; // account2_id is the person who received the friend request
            $status = "pending";

            $friend = new Friend($account1_id, $account2_id, $status);
            if ($friendService->CheckIfExist($account1_id, $account2_id)) {
                echo json_encode(null);
            } else{
                $result = $friendService->insert($friend);
                echo json_encode($result);
            }
            
        }

        // receive friend request
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            $friendService = new FriendService();
            $account_id = $_SESSION['account_id'];
            $friends = $friendService->getFriendRequests($account_id);
            if ($friends){
                echo json_encode($friends);
            } else {
                echo json_encode(null);
            }
        }
    }
}