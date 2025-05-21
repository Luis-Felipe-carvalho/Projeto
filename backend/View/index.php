<?php
session_start();
require_once __DIR__ . '/../../config.php'; // Caminho correto para o config.php

$logged_in = isset($_SESSION["user_id"]); // Verifica se há um usuário logado

$feedback_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $mensagem = trim($_POST['mensagem']);
    $Assunto = trim($_POST['Assunto']);

    if (!empty($nome) && !empty($email) && !empty($mensagem) && !empty($Assunto)) {
        $stmt = $pdo->prepare("INSERT INTO feedback (nome, email, mensagem, Assunto) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nome, $email, $mensagem, $Assunto])) {
            $feedback_msg = "<p style='color: green;'>Feedback enviado com sucesso!</p>";
        } else {
            $feedback_msg = "<p style='color: red;'>Erro ao enviar feedback.</p>";
        }
    } else {
        $feedback_msg = "<p style='color: red;'>Todos os campos são obrigatórios.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta Nome="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto de vida - Estudante de programação</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Navigation -->
    <header id="navbar">
        <div class="container">
            <a href="index.php" class="logo">Projeto de <span>Vida</span></a>
            <nav>
                <ul class="desktop-nav">
                    <?php if ($logged_in): ?>
                        <li><a href="index.php?#Inicio">Início</a></li>
                        <li><a href="user.php">Perfil</a></li>
                    <?php else: ?>
                        <li><a href="index.php?#Inicio">Início</a></li>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>

                <button id="mobile-menu-btn" aria-label="Toggle menu">
                    <span>
                        <li><a href="#Inicio">Início</a></li>
                    </span>
                    <span>
                        <li><a href="User.php">Perfil</a></li>
                    </span>
                </button>
            </nav>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu">
            <ul>
                <li><a href="#Inicio">Início</a></li>
                <li><a href="Perfil.php">Perfil</a></li>
            </ul>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="Inicio" class="hero">
        <div class="container">
            <h1>
                <span class="title-line">Projeto</span>
                <span class="gradient-text">De Vida</span>
            </h1>
            <p class="subtitle">
                Explorando o caminho do ensino médio ao desenvolvimento profissional.
            </p>
            <div class="buttons">
                <a href="#Sobre" class="btn btn-primary">Sobre mim</a>
            </div>
    <!-- Sobre Section -->
    <section id="Sobre" class="section">
        <div class="container">
            <div class="section-header">
                <h2>Engenharia Civil & <span class="gradient-text">Arquitetura</span></h2>
                <p class="section-description">
                   
            </div>

            <div class="features">
                <div class="feature-card">
                    <div class="icon">
                        <div class="icon-code"></div>
                    </div>
                    <h3>Programação</h3>
                    <p>Apesar de não ser o meu forte, estou achando interessante aprender sobre logica de programação.</p>
                </div>
                <div class="feature-card">
                    <div class="icon">
                        <div class="icon-monitor"></div>
                    </div>
                    <h3>Engenharia Civil</h3>
                    <p>se dedica ao planejamento, projeto, construção e manutenção de infraestruturas físicas e naturais, como edifícios, pontes, estradas, túneis, barragens e sistemas de saneamento.</p>
                </div>
                <div class="feature-card">
                    <div class="icon">
                        <div class="icon-cpu"></div>
                    </div>
                    <h3>
                        Arquitetura</h3>
                    <p> Se dedica ao planejamento, projeto e construção de edifícios e espaços urbanos, integrando aspectos funcionais, estéticos e técnicos.</p>
                </div>
                <div class="feature-card">
                    <div class="icon">
                        <div class="icon-book"></div>
                    </div>
                    <h3>Conhecimentos Necessarios</h3>
                    <p>envolve uma combinação de conhecimentos teóricos e práticos, incluindo disciplinas como matemática, física, desenho técnico e, para arquitetos, também história da arte e urbanismo. </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Educacao Section -->
    <section id="Educacao" class="section section-alt">
        <div class="container">
            <div class="section-header">
                <div class="icon-circle">
                    <div class="icon-graduation"></div>
                </div>
            <div class="Contato-info">
                <h3>Informações de contato</h3>
                <div class="info-item">
                    <div class="icon-mail"></div>
                    <div>
                        <h4>Email</h4>
                        <p>luisfelipecarvalho.sesisenai@gmail.com</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="icon-map-pin"></div>
                    <div>
                        <h4>
                            Localização</h4>
                        <p>SESI 380 Centro Educacional de Paraguaçu Paulista</p>
                    </div>
                </div>
                <div class="social-links">
                    <a href="#" class="social-icon linkedin"></a>
                    <a href="#" class="social-icon twitter"></a>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>© <span id="current-year"></span> Projeto de vida. Todos os Direitos Reservados.</p>

            <p>Projetado com paixão por um entusiasta da programação, <span>Powered by https://github.com/Eric-codecrypt</span></p>
        </div>
    </footer>

    <!-- Particles Background -->
    <canvas id="particles"></canvas>

    <script src="script.js"></script>
</body>

</html>