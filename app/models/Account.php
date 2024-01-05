<?php
namespace app\models;


class Account implements \JsonSerializable
{

    private int $account_id;
    private string $username;
    private string $password;
    private string $email;

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    public function __construct(){

    }

    // work around for not being able to have multiple constructors :)
    public function WithAllData(int $account_id, string $username, string $password, string $email)
    {
        $instance = new self();
        $instance->account_id = $account_id;
        $instance->username = $username;
        $instance->password = $password;
        $instance->email = $email;
        return $instance;
    }

    // getters

    public function getAccountId(): int
    {
        return $this->account_id;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    // setters

    public function setAccountId(int $account_id)
    {
        $this->account_id = $account_id;
    }
    public function setUsername(string $username)
    {
        $this->username = $username;
    }
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    public function setEmail(string $email)
    {
        $this->email = $email;
    }


}

?>