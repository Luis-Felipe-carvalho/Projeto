<?php
include_once  'C:/Turma2/xampp/htdocs/Projeto-de-vida/backend/Controller/UserController.php';
include_once 'C:/Turma2/xampp/htdocs/Projeto-de-vida/config.php';

$Controller = new UserController($pdo);

if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $currentdatetime = new DateTime('now');
    $data_de_registro = $currentdatetime->format("Y-m-d H:i:s" . ".000000");


    $registred = $Controller->register($username, $email, $password, $data_de_registro);
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
    <link rel="stylesheet" href="styles.css">
</head>

<style>
                .features {
                    display: flex;
                    justify-content: center;
                    margin: 0 auto;
                    width: 300px;
                }

                input {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    margin: 0 auto;
                    width: 30vh;
                    height: 5vh;
                    font-size: 20px;
                    padding: 10px;

                }

                header {
                    display: flex;
                    justify-content: center;
                    margin-top: 40px
                }

                form {
                    margin-top: -40px;
                }

                .login_google {
                    display: flex;
                    justify-content: center;
                    flex-direction: column;
                }

                h3 {
                    display: flex;
                    justify-content: center;
                    margin-top: 10px;
                }

                .google {
                    display: flex;
                    justify-content: center;
                }

                p {
                    display: flex;
                    justify-items: center;
                    margin-top: 10px;
                    margin: 0 auto;
                }

                .botao2 {
                    margin-top: 10px;
                }
            
            </style>

<body class="features">
    <div class="feature-card">
        <header>
            <h1>Registrar</h1>
        </header>
        <br>
        <br>
        <br>
        <br>
        <br>
        <section>
            <div>
                <form method="POST" enctype="multipart/form-data">
                    <input required type="text" name="username" placeholder="nome de usuário">
                    <input required type="email" name="email" placeholder="email">
                    <input required type="password" name="password" placeholder="senha">
                    <br>
                    <button class="btn" type="submit">Cadastrar Conta</button>
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
            <br>
            <br>
            <p>
                Já tem uma conta?
            <div>
                <button class="btn"><a href="login.php">Faça login</a></button>
            </div>
            </p>
        </section>
    </div>



</html>