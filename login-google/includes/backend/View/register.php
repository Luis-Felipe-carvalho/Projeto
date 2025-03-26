<?php
include_once  'C:\Turma2\xampp\htdocs\Projeto de vida\Controller\UserController.php';
include_once 'C:\Turma2\xampp\htdocs\Projeto de vida\config.php';

$Controller = new UserController($pdo);

if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $currentdatetime = new DateTime('now');
    $data_de_registro = $currentdatetime->format("Y-m-d H:i:s" . ".000000");


    $registred = $Controller->register($username, $password, $data_de_registro);
    $error_code = 0;

    if ($registred && $error_code == null) {
        header("Location: login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>registrar</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <header>
        <h1>Projeto de vida</h1>
    </header>
    <section>
        <div>
            <form method="POST" enctype="multipart/form-data">
                <input required type="text" name="username" placeholder="nome de usuário">
                <input required type="password" name="password" placeholder="senha">
                <button type="submit">Cadastrar Conta</button>
            </form>
        </div>

        

       


        <?php
        if (isset($registred) && !$registred) {
            echo "<p>esse usuário ja existe! tente outro nome de usuário.</p>";
        }
        if (isset($error_code) && $error_code != null) {
            echo $error_code;
        }
        ?>
        <p>
            Já tem uma conta?
        <div><button><a href="login.php">Faça login</a></button></div>
        </p>
    </section>

   


</html>