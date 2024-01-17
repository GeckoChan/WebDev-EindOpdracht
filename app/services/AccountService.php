<?php
namespace app\services;
use app\repositories\AccountRepository;

class AccountService {
    public function getAll(){
        $accountRepository = new AccountRepository();
        $accounts = $accountRepository->getAll();
        return $accounts;
    }

    public function insert($account){
        $accountRepository = new AccountRepository();
        $accountRepository->insert($account);
    }

    public function remove($account_id){
        $accountRepository = new AccountRepository();
        return $accountRepository->remove($account_id);
    }

    public function updateAccount($account){
        $accountRepository = new AccountRepository();
        return $accountRepository->updateAccount($account);
    }

    public function checkIfExist($username, $password){
        $accountRepository = new AccountRepository();
        $account = $accountRepository->checkIfExist($username, $password);
        return $account;
    }
}

?>