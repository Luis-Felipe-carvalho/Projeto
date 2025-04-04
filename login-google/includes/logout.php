<?php

//autoload do composer
require __DIR__ . '/vendor/autoload.php';

//dependencias
use App\Session\User as SessionUser;


//desloga o usuario
SessionUser::logout();

//redireciona o usuario para home
header('location: index.php');
exit;



