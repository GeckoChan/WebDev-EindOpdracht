<?php
namespace app\models;


class Like implements \JsonSerializable {
        
    private int $like_id;
    private Account $account_id;
    private Post $post_id;
    
    public function jsonSerialize() : mixed {
        return get_object_vars($this);
    }
    
    public function construct(int $like_id, Account $account_id, Post $post_id) {
        $this->like_id = $like_id;
        $this->account_id = $account_id;
        $this->post_id = $post_id;
    }
    
    // getters
    
    public function getLikeId() : int {
        return $this->like_id;
    }
    public function getAccountId() : Account {
        return $this->account_id;
    }
    public function getPostId() : Post {
        return $this->post_id;
    }

    // setters

    public function setLikeId(int $like_id) {
        $this->like_id = $like_id;
    }
    public function setAccountId(Account $account_id) {
        $this->account_id = $account_id;
    }
    public function setPostId(Post $post_id) {
        $this->post_id = $post_id;
    }
}