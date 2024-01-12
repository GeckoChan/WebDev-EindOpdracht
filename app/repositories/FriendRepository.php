<?php
namespace app\repositories;
use app\models\Friend;
use app\models\Account;

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
        $result = $stmt->execute([
            'account1_id' => $friend->getAccount1Id(),
            'account2_id' => $friend->getAccount2Id(),
            'status' => $friend->getStatus()
        ]);
        return $result;
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
        // check both ways
        $stmt = $this->connection->prepare("SELECT * FROM friends WHERE account1_id = :account1_id AND account2_id = :account2_id AND status = :status");
        $stmt->execute([
            'account1_id' => $account1_id,
            'account2_id' => $account2_id,
            'status' => "pending"
        ]);
        $result = $stmt->fetch();
        if ($result) {
            return true;
        }

        $stmt = $this->connection->prepare("SELECT * FROM friends WHERE account1_id = :account1_id AND account2_id = :account2_id AND status = :status");
        $stmt->execute([
            'account1_id' => $account2_id,
            'account2_id' => $account1_id,
            'status' => "pending"
        ]);
        $result = $stmt->fetch();
        if ($result) {
            return true;
        }

        // No friend request in either direction
        return false;
    }

    function getFriendRequests($account_id){
        $stmt = $this->connection->prepare("SELECT accounts.account_id, accounts.username, accounts.email FROM accounts 
                                            inner JOIN friends ON friends.account1_id = accounts.account_id 
                                            WHERE friends.account2_id = :account_id
                                            AND friends.status = :status; ");
        $stmt->execute([
            'account_id' => $account_id,
            'status' => "pending"
        ]);
    
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Account::class);
        $accounts = $stmt->fetchAll();
    
        return $accounts;
    }

    function getFriends($account_id){
        $stmt = $this->connection->prepare("SELECT accounts.account_id, accounts.username, accounts.email FROM accounts 
                                            inner JOIN friends ON friends.account1_id = accounts.account_id 
                                            WHERE friends.account2_id = :account_id
                                            AND friends.status = :status; ");
        $stmt->execute([
            'account_id' => $account_id,
            'status' => "accepted"
        ]);
    
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Account::class);
        $accounts = $stmt->fetchAll();
    
        return $accounts;
    }

    function acceptFriendRequest($account1_id, $account2_id){
        // check both ways
        $stmt = $this->connection->prepare("UPDATE friends SET status = :status WHERE account1_id = :account1_id AND account2_id = :account2_id AND status = :currentstatus");
        $stmt->execute([
            'account1_id' => $account1_id,
            'account2_id' => $account2_id,
            'status' => "accepted",
            'currentstatus' => "pending"  
        ]);
        if ($stmt->rowCount() > 0) {
            return true;
        }
    
        $stmt = $this->connection->prepare("UPDATE friends SET status = :status WHERE account1_id = :account1_id AND account2_id = :account2_id AND status = :currentstatus");
        $stmt->execute([
            'account1_id' => $account2_id,
            'account2_id' => $account1_id,
            'status' => "accepted",
            'currentstatus' => "pending"  
        ]);
        if ($stmt->rowCount() > 0) {
            return true;
        }
    
        // update failed
        return false;
    }
}
?>