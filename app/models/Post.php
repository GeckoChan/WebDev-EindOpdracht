<?php
namespace app\models;

class Post implements \JsonSerializable {
    
    private int $post_id;
    private Account $created_by;
    private ?Post $parent_post_id;
    private \datetime $created_at;
    private string $content;

    public function jsonSerialize() : mixed {
        return get_object_vars($this);
    }

    public function construct(int $post_id, Account $created_by, ?Post $parent_post_id, \datetime $created_at, string $content) {
        $this->post_id = $post_id;
        $this->created_by = $created_by;
        $this->parent_post_id = $parent_post_id;
        $this->created_at = $created_at;
        $this->content = $content;
    }

    // getters

    public function getPostId() : int {
        return $this->post_id;
    }
    public function getCreatedBy() : Account {
        return $this->created_by;
    }
    public function getParentPostId() : ?Post {
        return $this->parent_post_id;
    }
    public function getCreatedAt() : \datetime {
        return $this->created_at;
    }
    public function getContent() : string {
        return $this->content;
    }

    // setters

    public function setPostId(int $post_id) {
        $this->post_id = $post_id;
    }
    public function setCreatedBy(Account $created_by) {
        $this->created_by = $created_by;
    }
    public function setParentPostId(?Post $parent_post_id) {
        $this->parent_post_id = $parent_post_id;
    }
    public function setCreatedAt(\datetime $created_at) {
        $this->created_at = $created_at;
    }
    public function setContent(string $content) {
        $this->content = $content;
    }
}