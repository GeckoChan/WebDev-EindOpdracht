<?php
namespace app\repositories;
use app\models\Post;
use app\models\Account;

class PostRepository extends Repository{
    function getAllPosts() {
        $stmt = $this->connection->prepare("SELECT posts.*, accounts.username
                                            FROM posts
                                            INNER JOIN accounts ON posts.created_by = accounts.account_id");
        $stmt->execute();
    
        $postsData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $posts = [];
    
        foreach ($postsData as $postData) {
            $post = new Post();
            $post->setPostId($postData['post_id']);

            $account = new Account();
            $account->setAccountId($postData['created_by']);
            $account->setUsername($postData['username']);
            $post->setCreatedBy($account);

            $post->setParentPostId($postData['parent_post_id']);
            $post->setCreatedAt(new \DateTime($postData['created_at']));
            $post->setContent($postData['post_content']);
            
    
            $posts[] = $post;
        }
    
        return $posts;
    }

    function insertPost($post){
        $stmt = $this->connection->prepare("INSERT INTO posts (created_by , post_content) VALUES (:account_id, :content)");
        $stmt->execute([
            'account_id' => $post->getCreatedBy()->getAccountId(),
            'content' => $post->getContent(),
        ]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function remove($post_id){
        $stmt = $this->connection->prepare("DELETE FROM posts WHERE post_id = :post_id");
        $stmt->execute([
            'post_id' => $post_id
        ]);
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

    function update($post){
        $stmt = $this->connection->prepare("UPDATE posts SET created_by = :account_id, post_content = :content, date = :date WHERE post_id = :post_id");
        $stmt->execute([
            'post_id' => $post->getPostId(),
            'account_id' => $post->getAccountId(),
            'content' => $post->getContent(),
            'date' => $post->getDate()
        ]);
    }
}

?>