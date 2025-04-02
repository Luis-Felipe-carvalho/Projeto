<?php

// Autoload de classes do Composer
require __DIR__ . '/vendor/autoload.php';

// Importa a classe User.php corretamente
require_once __DIR__ . '/../app/Session/User.php';

// Dependências
use App\Session\User as SessionUser;

// Caminho correto para incluir user.php ou login.php
$includePath = SessionUser::isLogged() ? 
    __DIR__ . '/user.php' : // Volta um nível para encontrar user.php
    __DIR__ . '/login.php'; // Login já está na mesma pasta

if (file_exists($includePath)) {
    include $includePath;
} else {
    die("Erro: Arquivo não encontrado -> $includePath");
}


