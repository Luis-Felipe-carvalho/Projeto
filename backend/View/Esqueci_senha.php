<?php
session_start();
include_once 'C:/Turma2/xampp/htdocs/Projeto-de-vida/backend/Controller/UserController.php';
include_once 'C:/Turma2/xampp/htdocs/Projeto-de-vida/config.php';

$Controller = new UserController($pdo);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $new_password = password_hash( $_POST['new_password'], PASSWORD_DEFAULT);

    // Verificar se o e-mail e senha atual estão corretos
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $new_password != $user['password']) { 
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$new_password, $user['id']]);

        echo "<p>Senha alterada com sucesso.</p>";
        header("Location: login.php");
    } else {
        echo "<p>E-mail ou senha atual incorretos.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h2>Alterar Senha</h2>
    <form method="POST">
        <label for="email">E-mail cadastrado:</label>
        <input type="email" id="email" name="email" required>

        <label for="new_password">Nova Senha:</label>
        <input type="password" id="new_password" name="new_password" required>

        <button type="submit">Alterar Senha</button>
    </form>
</body>

</html>