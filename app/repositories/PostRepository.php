<?php
namespace app\repositories;
use app\models\Post;

class PostRepository extends Repository{
    function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM posts");
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $posts = $stmt->fetchAll();

        return $posts;
    }

    function insert($post){
        $stmt = $this->connection->prepare("INSERT INTO posts (account_id, content, date) VALUES (:account_id, :content, :date)");
        $stmt->execute([
            'account_id' => $post->getAccountId(),
            'content' => $post->getContent(),
            'date' => $post->getDate()
        ]);
    }

    function remove($post_id){
        $stmt = $this->connection->prepare("DELETE FROM posts WHERE post_id = :post_id");
        $stmt->execute([
            'post_id' => $post_id
        ]);
    }

    function update($post){
        $stmt = $this->connection->prepare("UPDATE posts SET account_id = :account_id, content = :content, date = :date WHERE post_id = :post_id");
        $stmt->execute([
            'post_id' => $post->getPostId(),
            'account_id' => $post->getAccountId(),
            'content' => $post->getContent(),
            'date' => $post->getDate()
        ]);
    }
}

?>