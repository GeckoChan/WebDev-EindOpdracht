<?php
namespace app\models;

class Friend implements \JsonSerializable {
    
    private int $friend_id;
    private Account $account1_id; // account1_id is the person who sent the friend request
    private Account $account2_id; // account2_id is the person who received the friend request
    private string $status;
    private \datetime $created_at;

    public function jsonSerialize() : mixed {
        return get_object_vars($this);
    }

    public function __construct(Account $account1_id, Account $account2_id, string $status) {
        $this->account1_id = $account1_id;
        $this->account2_id = $account2_id;
        $this->status = $status;
    }

    // work around for not being able to have multiple constructors :)
    public function WithIdAndDate(int $friend_id, Account $account1_id, Account $account2_id, string $status, \datetime $created_at) {
        $instance = new self($account1_id, $account2_id, $status);
        $instance->setFriendId($friend_id);
        $instance->setCreatedAt($created_at);
        return $instance;
    }

    // getters

    public function getFriendId() : int {
        return $this->friend_id;
    }
    public function getAccount1Id() : Account {
        return $this->account1_id;
    }
    public function getAccount2Id() : Account {
        return $this->account2_id;
    }
    public function getStatus() : string {
        return $this->status;
    }
    public function getCreatedAt() : \datetime {
        return $this->created_at;
    }


    // setters

    public function setFriendId(int $friend_id) {
        $this->friend_id = $friend_id;
    }
    public function setAccount1Id(Account $account1_id) {
        $this->account1_id = $account1_id;
    }
    public function setAccount2Id(Account $account2_id) {
        $this->account2_id = $account2_id;
    }
    public function setStatus(string $status) {
        $this->status = $status;
    }
    
    public function setCreatedAt(\datetime $created_at) {
        $this->created_at = $created_at;
    }
    
}

?>