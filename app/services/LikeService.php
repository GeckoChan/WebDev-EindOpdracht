<?php
namespace app\services;
use app\repositories\LikeRepository;
use app\models\Like;
use app\models\Post;
use app\models\Account;

class LikeService {

    public function likePost($post_id, $account_id) {
        // 3 connections to the db ;(
        $likeRepository = new LikeRepository();
        $like = $likeRepository->getLikeByPostIdAndAccountId($post_id, $account_id);
        if($like == null){
            $like = new Like();

            $post = new Post();
            $post->setPostId($post_id);
            $like->setPostId($post);

            $account = new Account();
            $account->setAccountId($account_id);
            $like->setAccountId($account);
            $likeRepository->insert($like);
        } else {
            $likeRepository->remove($like->getLikeId());
        }

        $likes_count = $likeRepository->getLikesCountForPost($post_id);
        if ($likes_count == null) {
            $likes_count = 0;
        }
        return $likes_count;
    }

}

?>