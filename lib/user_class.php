<?php
require_once __DIR__ . "/global_class.php";

class User extends GlobalClass
{
    public function __construct(DataBase $db)
    {
        parent::__construct("users", $db);
    }

    public function addUser(string $login, string $password, int $regdate): bool
    {
        if (!$this->checkValid($login, $password, $regdate)) return false;
        return $this->add(["login" => $login, "password" => $password, "regdate" => $regdate]);
    }

    public function editUser(int $id, string $login, string $password, int $regdate): bool
    {
        if (!$this->checkValid($login, $password, $regdate)) return false;
        return $this->edit($id, ["login" => $login, "password" => $password, "regdate" => $regdate]);
    }

    public function isExistsUser(string $login): bool
    {
        return $this->isExists("login", $login);
    }

    public function getUserOnLogin(string $login): ?array
    {
        $id = $this->getField("id", "login", $login);
        return $id ? $this->get((int)$id) : null;
    }

    private function checkValid(string $login, string $password, int $regdate): bool
    {
        if (!$this->valid->validLogin($login)) return false;
        if (!$this->valid->validHash($password)) return false;
        if (!$this->valid->validTimeStamp($regdate)) return false;
        return true;
    }
}