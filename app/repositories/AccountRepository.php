<?php
namespace app\repositories;
use app\models\Account;

class AccountRepository extends Repository{
    function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM accounts");
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Account::class);
        $accounts = $stmt->fetchAll();

        return $accounts;
    }

    function checkIfExist($username, $password) {
        $stmt = $this->connection->prepare("SELECT * FROM accounts WHERE username = :username");
        $stmt->execute([
            'username' => $username,
        ]);
    
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Account::class);
        $account = $stmt->fetch();
    
        if ($account && password_verify($password, $account->getPassword())) {
            return $account;
        }
    
        return null;
    }

    function insert($account){
        $stmt = $this->connection->prepare("INSERT INTO accounts (username, password, email) VALUES (:username, :password, :email)");
        $hash = password_hash($account->getPassword(), PASSWORD_DEFAULT);
        $stmt->execute([
            'username' => $account->getUsername(),
            'password' => $hash,
            'email' => $account->getEmail()
        ]);
    }

    function remove($account_id){
        $stmt = $this->connection->prepare("DELETE FROM accounts WHERE account_id = :account_id");
        $stmt->execute([
            'account_id' => $account_id
        ]);
        return $stmt->execute();
    }

    function updateAccount($account){
        $stmt = $this->connection->prepare("UPDATE accounts SET username = :username, password = :password, email = :email WHERE account_id = :account_id");
        $hash = password_hash($account->getPassword(), PASSWORD_DEFAULT);
        $stmt->execute([
            'account_id' => $account->getAccountId(),
            'username' => $account->getUsername(),
            'password' => $hash,
            'email' => $account->getEmail()
        ]);
        return $stmt->rowCount() > 0;
    }
}
?>