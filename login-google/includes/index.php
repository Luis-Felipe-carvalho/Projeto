<?php

//autoload de classes do composer
require __DIR__.'/vendor/autoload.php';

//Dependencias
use \App\Session\User as SessionUser;

include SessionUser::isLogged() ?
__DIR__.'/includes/backend/View/profile.php' :
__DIR__.'/includes/backend/View/login.php';