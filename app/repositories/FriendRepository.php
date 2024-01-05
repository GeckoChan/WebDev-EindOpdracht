<?php
namespace app\repositories;
use app\models\Friend;

class FriendRepository extends Repository{
    function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM friends");
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Friend::class);
        $friends = $stmt->fetchAll();

        return $friends;
    }

    function insert($friend){
        $stmt = $this->connection->prepare("INSERT INTO friends (account1_id, account2_id, status) VALUES (:account1_id, :account2_id, :status)");
        $stmt->execute([
            'account1_id' => $friend->getAccount1Id(),
            'account2_id' => $friend->getAccount2Id(),
            'status' => $friend->getStatus()
        ]);
    }

    function remove($friend_id){
        $stmt = $this->connection->prepare("DELETE FROM friends WHERE friend_id = :friend_id");
        $stmt->execute([
            'friend_id' => $friend_id
        ]);
    }

    function update($friend){
        $stmt = $this->connection->prepare("UPDATE friends SET account1_id = :account1_id, account2_id = :account2_id, status = :status WHERE friend_id = :friend_id");
        $stmt->execute([
            'friend_id' => $friend->getFriendId(),
            'account1_id' => $friend->getAccount1Id(),
            'account2_id' => $friend->getAccount2Id(),
            'status' => $friend->getStatus()
        ]);
    }

    function checkIfExist($account1_id, $account2_id){
        $stmt = $this->connection->prepare("SELECT * FROM friends WHERE (account1_id = :account1_id AND account2_id = :account2_id) OR (account1_id = :account2_id2 AND account2_id = :account1_id2)");
        $stmt->execute([
            'account1_id' => $account1_id,
            'account2_id' => $account2_id,
            'account1_id2' => $account2_id,
            'account2_id2' => $account1_id
        ]);
    
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Friend::class);
        $friend = $stmt->fetch();
    
        return $friend;
    }
}
?>