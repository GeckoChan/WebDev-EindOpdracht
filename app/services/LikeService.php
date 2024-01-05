<?php
namespace app\services;
use app\repositories\LikeRepository;

class LikeService {
    public function getAll(){
        $likeRepository = new LikeRepository();
        $likes = $likeRepository->getAll();
        return $likes;
    }

    public function insert($like){
        $likeRepository = new LikeRepository();
        $likeRepository->insert($like);
    }

    public function remove($like_id){
        $likeRepository = new LikeRepository();
        $likeRepository->remove($like_id);
    }

    public function update($like){
        $likeRepository = new LikeRepository();
        $likeRepository->update($like);
    }
}

?>