<?php
class UserModel
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    function register($username, $password, $data_de_registro)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($results)) {
            $sql = "INSERT INTO users(username,password, data_de_registro) VALUES (?,?,?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username, $password, $data_de_registro]);
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $password]);
        $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt;
    }
    public function getUserFromID($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt;
    }
    public function updatenickname($username)
    {
        $sql = "UPDATE * FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt;
    }
}
