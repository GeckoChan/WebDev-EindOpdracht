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
        $friendRepository->insert($friend);
    }

    public function remove($friend_id){
        $friendRepository = new FriendRepository();
        $friendRepository->remove($friend_id);
    }

    public function update($friend){
        $friendRepository = new FriendRepository();
        $friendRepository->update($friend);
    }
}

?>