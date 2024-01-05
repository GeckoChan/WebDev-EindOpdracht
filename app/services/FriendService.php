<?php 
namespace app\services;
use app\repositories\FriendRepository;

class FriendService {
    public function getAll(){
        $friendRepository = new FriendRepository();
        $friends = $friendRepository->getAll();
        return $friends;
    }

    public function insert($friend){
        $friendRepository = new FriendRepository();
        return $friendRepository->insert($friend);
    }

    public function remove($friend_id){
        $friendRepository = new FriendRepository();
        $friendRepository->remove($friend_id);
    }

    public function update($friend){
        $friendRepository = new FriendRepository();
        $friendRepository->update($friend);
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
}

?>