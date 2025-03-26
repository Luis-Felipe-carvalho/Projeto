<?php
require_once __DIR__.'/../model/UserModel.php';

class UserController{
    private $UserModel;

    function __construct($pdo){
        $this->UserModel = new UserModel($pdo);
    }
    function register($username,$password,$data_de_registro){
        return $this->UserModel->register($username, $password,$data_de_registro);
    }
    public function login($username, $password){
        return $this->UserModel->login($username,$password);
    }
    public function getUserFromID($id){
        return $this->UserModel->getUserFromID($id);
    }
    public function updatenickname($username){
        return $this->UserModel->updatenickname($username);
    }
}