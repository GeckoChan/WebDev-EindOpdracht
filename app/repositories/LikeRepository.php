<?php
namespace app\repositories;
use app\models\Like;

class LikeRepository extends Repository {
    function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM likes");
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Like::class);
        $likes = $stmt->fetchAll();

        return $likes;
    }

    function insert($like){
        $stmt = $this->connection->prepare("INSERT INTO likes (account_id, post_id) VALUES (:account_id, :post_id)");
        $stmt->execute([
            'account_id' => $like->getAccountId(),
            'post_id' => $like->getPostId()
        ]);
    }

    function remove($like_id){
        $stmt = $this->connection->prepare("DELETE FROM likes WHERE like_id = :like_id");
        $stmt->execute([
            'like_id' => $like_id
        ]);
    }

    function update($like){
        $stmt = $this->connection->prepare("UPDATE likes SET account_id = :account_id, post_id = :post_id WHERE like_id = :like_id");
        $stmt->execute([
            'like_id' => $like->getLikeId(),
            'account_id' => $like->getAccountId(),
            'post_id' => $like->getPostId()
        ]);
    }
}