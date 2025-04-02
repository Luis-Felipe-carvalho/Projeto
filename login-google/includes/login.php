<?php

//autoload do composer
require __DIR__ . '/vendor/autoload.php';

//dependencias

use App\Session\User;
use Google\Client as GoogleClient;
require_once "C:/Turma2/xampp/htdocs/Projeto-de-vida/login-google/app/Session/User.php";
//validação principal do cookie
$User = new User();

//Verifica os campos obrigatorios
if (!isset($_POST['credential']) || !isset($_POST['g_csrf_token'])) {
  header('location: index.php');
  exit;
}

//COOKIE
$cookie = $_COOKIE['g_csrf_token'] ?? '';

//Verifica o valor do cookie e do POST para o CSRF
if ($_POST['g_csrf_token'] != $cookie) {
  header('location: index.php');
  exit;
}

//Validação secudaria do token


//Instancia do cliente google
$client = new GoogleClient(['client_id' => '659345250941-hp6n6p2g45ogrgt0noqplur9tegi36vo.apps.googleusercontent.com']);

//Obtem os dados do usuario com base no JWT
$payload = $client->verifyIdToken($_POST['credential']);

//Verifica os dados do payload
if (isset($payload['email'])) {
  User::login($payload['name'], $payload['email']);
  header('location: index.php');
  exit;
}

//Problemas ao consultar a API
die('Problemas ao consultar API');
