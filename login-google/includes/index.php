<?php
// Autoload do Composer
require __DIR__ . '/vendor/autoload.php';


// Dependências
use App\Session\User;

// Usar o caminho absoluto baseado no diretório raiz do servidor
require_once "C:/Turma2/xampp/htdocs/Projeto-de-vida/login-google/app/Session/User.php"; // Caminho absoluto


$User = new User();
// Retorna as informações da sessão do usuário
$info = $User->getinfo();

// Verifica se o usuário está logado e define o caminho correto
$includePath = User::isLogged() ? 
    __DIR__ . '/../../backend/View/user.php' : // Caminho correto para user.php
    __DIR__ . '/login.php'; // Login continua na mesma pasta

if (file_exists($includePath)) {
    include $includePath;
} else {
    die("Erro: Arquivo não encontrado -> $includePath");
}
?>
