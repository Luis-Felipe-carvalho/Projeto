<?php
include_once 'C:\Turma2\xampp\htdocs\Grupo3Projeto2025\Controller\UserController.php';
include_once 'C:\Turma2\xampp\htdocs\Grupo3Projeto2025\config.php';

$Controller = new UserController($pdo);

if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $logged_in = $Controller->login($username, $password);

    if (!empty($logged_in)) {
        setcookie("id_user", $logged_in["id"], time() + 60 * 60 * 24, "/");
        header("Location: user.php");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">

    <title>Pagina de login</title>
</head>

<body>
    <header class="">

        <h1>Login</h1>
    </header>

    <section>
        <div>
            <form method="POST">
                <input required type="text" name="username" placeholder="nome de usuário">
                <input required type="password" name="password" placeholder="senha">

                <button type="submit">Login</button>
                <h3>ou</h3>
                <h3>logue com o Google</h3>
                <html>

                <body>
                    <script src="https://accounts.google.com/gsi/client" async></script>
                    <div id="g_id_onload"
                        data-client_id="659345250941-hp6n6p2g45ogrgt0noqplur9tegi36vo.apps.googleusercontent.com"
                        data-login_uri="http://localhost/Projeto-de-vida/login-google/login.php"
                        data-auto_prompt="false">
                    </div>
                    <div class="g_id_signin"
                        data-type="standard"
                        data-size="large"
                        data-theme="outline"
                        data-text="sign_in_with"
                        data-shape="rectangular"
                        data-logo_alignment="left">
                    </div>

                    <body>

                </html>
            </form>
            <p>

        </div>
        Não tem uma conta? registre uma</p>
        <div class="outro"><button><a href="register.php">aqui!</a></button></div>



        <?php
        if (isset($logged_in) && empty($logged_in)) {
            echo "usuário ou senha estão errados, tente novamente!";
        } else {
        }
        ?>
    </section>

</html>