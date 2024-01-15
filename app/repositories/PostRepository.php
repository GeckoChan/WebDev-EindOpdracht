<?php
namespace app\repositories;
use app\models\Post;
use app\models\Account;

class PostRepository extends Repository{
    function getAllPosts() {
        $stmt = $this->connection->prepare("SELECT posts.*, accounts.username, (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id) as likes_count
                                            FROM posts
                                            INNER JOIN accounts ON posts.created_by = accounts.account_id
                                            WHERE posts.parent_post_id IS NULL");
        $stmt->execute();
    
        $postsData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $post = [];
    
        foreach ($postsData as $postData) {
            $post[] = $this->createPostObject($postData); // i hate php, instead of doing += on the array = is enough >:(
        }
    
        return $post;
    }

    function getAllFriendPosts($account_id) {
        $stmt = $this->connection->prepare("SELECT posts.*, accounts.username, (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id) as likes_count
                                            FROM posts
                                            INNER JOIN accounts ON posts.created_by = accounts.account_id
                                            WHERE posts.parent_post_id IS NULL 
                                            AND
                                            (posts.created_by IN (SELECT account2_id FROM friends WHERE account1_id = :account_id AND status = 'accepted'))
                                            OR 
                                            (posts.created_by IN (SELECT account1_id FROM friends WHERE account2_id = :account_id AND status = 'accepted'))");
        $stmt->execute([
            'account_id' => $account_id
        ]);

        $postsData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $posts = [];
    
        foreach ($postsData as $postData) {
            $posts[] = $this->createPostObject($postData);
        }
    
        return $posts;
    }

    function getPostById($post_id){
        $stmt = $this->connection->prepare("SELECT posts.*, accounts.username, (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id) as likes_count
                                            FROM posts
                                            INNER JOIN accounts ON posts.created_by = accounts.account_id
                                            WHERE post_id = :post_id");
        $stmt->execute([
            'post_id' => $post_id
        ]);
    
        $postsData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $posts = [];
    
        foreach ($postsData as $postData) {
            $posts[] = $this->createPostObject($postData);
        }
    
        return $posts;
    }

    function getReactionsForPost($parent_post_id) {
        $stmt = $this->connection->prepare("SELECT posts.*, accounts.username, (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id) as likes_count
                                            FROM posts
                                            INNER JOIN accounts ON posts.created_by = accounts.account_id
                                            WHERE posts.parent_post_id = :parent_post_id");
        $stmt->execute([
            'parent_post_id' => $parent_post_id
        ]);

        $postsData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $posts = [];
    
        foreach ($postsData as $postData) {
            $posts[] = $this->createPostObject($postData);
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

    function insertReaction($post){
        $stmt = $this->connection->prepare("INSERT INTO posts (created_by , post_content , parent_post_id) VALUES (:account_id, :content, :parent_post_id)");
        $stmt->execute([
            'account_id' => $post->getCreatedBy()->getAccountId(),
            'content' => $post->getContent(),
            'parent_post_id' => $post->getParentPostId()
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

    private function createPostObject($postData){
        $post = new Post();
        $post->setPostId($postData['post_id']);

        $account = new Account();
        $account->setAccountId($postData['created_by']);
        $account->setUsername($postData['username']);
        $post->setCreatedBy($account);

        $post->setParentPostId($postData['parent_post_id']);
        $post->setCreatedAt(new \DateTime($postData['created_at']));
        $post->setContent($postData['post_content']);
        $post->setLikes($postData['likes_count']);
        return $post;
    } 
}

?>