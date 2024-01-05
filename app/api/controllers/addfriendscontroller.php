<?php
use app\services\FriendService;
use app\models\Friend;

class AddFriendsController {
    private FriendService $friendService;
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $friendService = new FriendService();

            $json = file_get_contents('php://input');
            $data = json_decode($json);
            $account1_id = $data->account1_id; // account1_id is the person who sent the friend request
            $account2_id = $data->account2_id; // account2_id is the person who received the friend request
            $status = "pending";

            $friend = new Friend($account1_id, $account2_id, $status);
            $friendService->insert($friend);
        }
    }
}