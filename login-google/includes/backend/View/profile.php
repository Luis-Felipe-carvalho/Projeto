<?php

use App\Session\User;

// Usar o caminho absoluto baseado no diretório raiz do servidor
require_once "C:/Turma2/xampp/htdocs/Projeto-de-vida/login-google/app/Session/User.php"; // Caminho absoluto

$User = new User;
// Retorna as informações da sessão do usuário
$info = $User::getinfo();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto de vida - Estudante de programação</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap">
    <link rel="stylesheet" href="styles.css">
</head>

<style>
    img{
        border-radius: 100px;
    }
</style>

<body>

    <!-- Navigation -->
    <header id="navbar">
        <div class="container">
            <a href="#Inicio" class="logo">Projeto de <span>Vida</span></a>
            <nav>
                <ul class="desktop-nav">
                    <li><a href="../../../index.php?#Inicio">Início</a></li>
                    <li><a href="index.php?#Sobre">Sobre</a></li>
                    <li><a href="index.php?#Educacao">Educação</a></li>
                    <li><a href="index.php?#Carreira">Carreira</a></li>
                    <li><a href="index.php?#Contato">Contato</a></li>
                    <li><a href="index.php?Perfil.php">Perfil</a></li>
                </ul>

                <button id="mobile-menu-btn" aria-label="Toggle menu">
                    <span>
                        <li><a href="index.php?#Inicio">Início</a></li>
                    </span>
                    <span>
                        <li><a href="index.php?#Sobre">Sobre</a></li>
                    </span>
                    <span>
                        <li><a href="index.php?#Educacao">Educação</a></li>
                    </span>
                    <span>
                        <li><a href="index.php?#Carreira">Carreira</a></li>
                    </span>
                    <span>
                        <li><a href="index.php?#Contato">Contato</a></li>
                    </span>
                    <span>
                        <li><a href="index.php?Perfil.php">Perfil</a></li>
                    </span>
                </button>
            </nav>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu">
            <ul>
                <li><a href="index.php?#Inicio">Início</a></li>
                <li><a href="index.php?#Sobre">Sobre</a></li>
                <li><a href="index.php?#Educacao">Educação</a></li>
                <li><a href="index.php?#Carreira">Carreira</a></li>
                <li><a href="index.php?#Contato">Contato</a></li>
                <li><a href="index.php?Perfil.php">Perfil</a></li>
            </ul>
        </div>
    </header>

    <main>
        <section class="features">
            <div class="feature-card">
                <div>
                <img src="data:image/jpeg;base64,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" alt="Foto de Perfil">
</div>
                <div>
                    <?= $info['name'] ?>
                    <br>
                    <?= $info['email'] ?>
                    <br>
                    <br>

                    <a href="logout.php">
                        <button class="btn">Sair</button>
                    </a>
                </div>

            </div>
        </section>
    </main>

</body>

</html>