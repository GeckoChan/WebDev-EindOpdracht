<?php
use app\services\FriendService;

class FriendsController{
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // var data = {
            //     account_id: globalAccount.accountId
            // }


            $friendService = new FriendService();
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            $account_id = $data->account_id;

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