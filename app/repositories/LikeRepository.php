<?php
namespace app\repositories;
use app\models\Like;
use app\models\Post;
use app\models\Account; 

class LikeRepository extends Repository {
    function getLikeByPostIdAndAccountId($post_id, $account_id){
        $stmt = $this->connection->prepare("SELECT * FROM likes WHERE post_id = :post_id AND account_id = :account_id");
        $stmt->execute([
            'post_id' => $post_id,
            'account_id' => $account_id
        ]);
    
        $likeData = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($likeData){
            return $this->createLikeObject($likeData);
        }
        return null;
    }

    function getLikesCountForPost($post_id){
        $stmt = $this->connection->prepare("SELECT COUNT(*) as likes_count FROM likes WHERE post_id = :post_id");
        $stmt->execute([
            'post_id' => $post_id
        ]);
    
        $likesCount = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $likesCount['likes_count'];
    }

    function insert($like){
        $stmt = $this->connection->prepare("INSERT INTO likes (account_id, post_id) VALUES (:account_id, :post_id)");
        $stmt->execute([
            'account_id' => $like->getAccountId()->getAccountId(),
            'post_id' => $like->getPostId()->getPostId()
        ]);
    }

    function remove($like_id){
        $stmt = $this->connection->prepare("DELETE FROM likes WHERE like_id = :like_id");
        $stmt->execute([
            'like_id' => $like_id
        ]);
    }

    function createLikeObject($likeData){
        $like = new Like();
        $like->setLikeId($likeData['like_id']);

        $account = new Account();
        $account->setAccountId($likeData['account_id']);
        $like->setAccountId($account);

        $post = new Post();
        $post->setPostId($likeData['post_id']);
        $like->setPostId($post);

        return $like;
    }
}