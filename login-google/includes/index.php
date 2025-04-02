<?php

//autoload de classes do composer
require __DIR__.'/vendor/autoload.php';
require_once __DIR__ . '/../app/Session/User.php';
//Dependencias
use App\Session\User as SessionUser;

include SessionUser::isLogged() ?
__DIR__.'C:/Turma2/xampp/htdocs/Projeto-de-vida/backend/View/user.php' :
__DIR__.'/login.php';

include '';
?> 