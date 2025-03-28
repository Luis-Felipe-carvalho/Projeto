<?php
require_once __DIR__.'/../Model/UserModel.php';

class UserController{
    private $UserModel;

    function __construct($pdo){
        $this->UserModel = new UserModel($pdo);
    }
    function register($username,$email, $password,$data_de_registro){
        return $this->UserModel->register($username,$email, $password,$data_de_registro);
    }
    public function login($username, $email, $password){
        return $this->UserModel->login($username,$email, $password);
    }
    public function getUserFromID($id){
        return $this->UserModel->getUserFromID($id);
    }
    public function updatenickname($username){
        return $this->UserModel->updatenickname($username);
    }
}