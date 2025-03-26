<?php
include_once __DIR__.'\Controller\UserController.php';
include_once __DIR__.'\config.php';

$Controller = new UserController($pdo);
if(!isset($_COOKIE['id_user'])){
    header("Location: index.php");
}
$username = $Controller->getUserFromID($_COOKIE['id_user'])["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto de vida</title>
</head>

<body>
   



    <main>

        <div method="POST">
            <h2>Nome de Usuário: <?=$username?></h2>
            <a href="logout.php"><button>Sair da conta</button></a>
            
        </div>
    </main>


</body>

</html>