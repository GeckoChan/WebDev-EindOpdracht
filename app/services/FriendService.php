<?php 
namespace app\services;
use app\repositories\FriendRepository;

class FriendService {

    public function insert($friend){
        $friendRepository = new FriendRepository();
        return $friendRepository->insert($friend);
    }

    public function declineFriendRequest($account1_id, $account2_id){
        $friendRepository = new FriendRepository();
        return $friendRepository->declineFriendRequest($account1_id, $account2_id);
    }

    public function CheckIfExist($account1_id, $account2_id){
        $friendRepository = new FriendRepository();
        $result = $friendRepository->CheckIfExist($account1_id, $account2_id);
        return $result;
    }

    public function getFriendRequests($account_id){
        $friendRepository = new FriendRepository();
        $friends = $friendRepository->getFriendRequests($account_id);
        return $friends;
    }

    public function getFriends($account_id){
        $friendRepository = new FriendRepository();
        $friends = $friendRepository->getFriends($account_id);
        return $friends;
    }

    public function acceptFriendRequest($account1_id, $account2_id){
        $friendRepository = new FriendRepository();
        $result = $friendRepository->acceptFriendRequest($account1_id, $account2_id);
        return $result;
    }

    public function removeFriend($account1_id, $account2_id){
        $friendRepository = new FriendRepository();
        $result = $friendRepository->removeFriend($account1_id, $account2_id);
        return $result;
    }
}
