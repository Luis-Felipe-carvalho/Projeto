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
                <a href="#Educacao" class="btn btn-secondary">Saiba mais</a>
            </div>
            <div class="scroll-indicator">
                <a href="#Sobre">
                    <span>
                        Role para baixo</span>
                    <div class="arrow-down"></div>
                </a>
            </div>
        </div>
    </section>

    <!-- Sobre Section -->
    <section id="Sobre" class="section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">SOBRE MIM</span>
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
                <h2>
                    Minha<span class="gradient-text"> Jornada </span>educacional</h2>
                <p class="section-description">
                    Construindo uma base sólida em ciência da computação por meio de educação formal e aprendizagem autodirigida.
                </p>
            </div>

            <div class="grid-two-col">
                <div>
                    <h3>Cronograma Acadêmico</h3>

                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="year">2024 - Presente</div>
                            <h4>
                                Ensino Médio - Curso de Programação<span class="badge">Atual</span></h4>
                            <p>Atualmente em um curso tecnico de programação, com foco em variados fundamentos do nicho, algoritmos e desenvolvimento de software.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="year">2025 - 2026</div>
                            <h4>Engenharia Civil</h4>
                            <p>
                                Planejando fazer engenharia civil para obter conhecimento maior para exercer a função.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="year">2026 - 2029</div>
                            <h4>Bacharel em Engenharia Civil</h4>
                            <p>Meta futura: cursar Engenharia Civil possivelmente em alguma faculdade do estado de SP.</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card">
                    <h3>Habilidades e Tecnologias</h3>

                    <div>
                        <h4>Atualmente aprendendo</h4>
                        <div class="skills">
                            <span class="skill-badge">HTML & CSS</span>
                            <span class="skill-badge">JavaScript</span>
                            <span class="skill-badge">Algoritmos basicos</span>
                            <span class="skill-badge">Resolução de Problemas</span>
                        </div>

                        <h4>Foco em habilidades futuras</h4>
                        <div class="skills">
                            <span class="skill-badge">React.js</span>
                            <span class="skill-badge">Node.js</span>
                            <span class="skill-badge">Sistemas de Banco de Dados</span>
                            <span class="skill-badge">Cloud Computing</span>
                            <span class="skill-badge">Desenvolvedor Mobile</span>
                            <span class="skill-badge">Inteligência artificial</span>
                            <span class="skill-badge">Machine Learning</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carreira Section -->
    <section id="Carreira" class="section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">ASPIRAÇÕES DE CARREIRA</span>
                <h2>Construindo um Futuro em <span class="gradient-text">Engenharia</span></h2>
                <p class="section-description">
                    Explorando possíveis caminhos de carreira no setor de tecnologia em constante evolução, com foco em inovação e resolução de problemas.
                </p>
            </div>

            <div class="Carreira-paths">
                <div class="Carreira-card">
                    <div class="icon">
                        <div class="icon-laptop"></div>
                    </div>
                    <h3> Infraestrutura Resiliente e Adaptativa</h3>
                    <p>Com as mudanças climáticas e o aumento de desastres naturais, a capacidade de projetar e construir infraestruturas que resistam a esses eventos (como inundações, terremotos) é crucial.</p>
                </div>

                <div class="Carreira-card">
                    <div class="icon">
                        <div class="icon-globe"></div>
                    </div>
                    <h3>
                    Geotecnia</h3>
                    <p> a geotecnia lida com a mecânica dos solos e rochas, sendo essencial para fundações, contenções, estabilidade de taludes e escavações. A demanda por especialistas nessa área tende a crescer continuamente.</p>
                   
                </div>

                <div class="Carreira-card">
                    <div class="icon">
                        <div class="icon-server"></div>
                    </div>
                    <h3>Saneamento e Recursos Hídricos:</h3>
                    <p>Com a crescente preocupação com a gestão da água e o saneamento básico, engenheiros civis com expertise em tratamento de água, esgoto, drenagem e gestão de recursos hídricos são cada vez mais necessários.</p>
                    
                </div>

                <div class="Carreira-card">
                    <div class="icon">
                        <div class="icon-code"></div>
                    </div>
                    <h3>
                    Gerenciamento de Projetos</h3>
                    <p>Da capacidade de gerenciar projetos complexos, coordenar equipes multidisciplinares e otimizar recursos é altamente valorizada no mercado.</p>
                    
                </div>
            </div>

            <div class="Carreira-plan">
                <h3>Meu Plano de Desenvolvimento de Carreira</h3>
                <ol>
                    <li><span>1</span>Construir uma base sólida de conhecimento teórico e prático na Engenharia Civil.</li>
                    <li><span>2</span>Ganhar experiência no mundo real da Engenharia Civil e aplicar o conhecimento teórico.</li>
                    <li><span>3</span> Dominar as ferramentas e conhecimentos técnicos essenciais para a prática da Engenharia Civil.</li>
                    <li><span>4</span>Aprimorar as habilidades interpessoais e de comunicação essenciais para o sucesso profissional.</li>
                    <li><span>5</span>Criar uma rede de contatos que possa te abrir portas e te manter atualizado sobre o mercado.</li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Contato Section -->
    <section id="Contato" class="section section-alt">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">ENTRE EM CONTATO</span>
                <h2><span class="gradient-text">Conecte-se</span> & colabore</h2>
                <p class="section-description">
                    Interessado em discutir sobre Engenharia?, compartilhar recursos ou explorar potenciais colaborações? Eu adoraria ouvir de você.
                </p>
            </div>

            <section id="Feedback" class="section">
                <div class="Contato-container">
                    <div class="Contato-form">
                        <h3>Me mande uma Mensagem</h3>
                        <?php if (isset($feedback_msg)) echo $feedback_msg; ?>
                        <form method="POST" id="ContatoForm">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="nome">Nome:</label>
                                    <input type="text" id="nome" name="nome" placeholder="Seu nome:" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail:</label>
                                    <input type="email" id="email" name="email" placeholder="Seu email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Assunto">Assunto</label>
                                <input type="text" id="Assunto" name="Assunto" placeholder="Assunto">
                            </div>
                            <div class="form-group">
                                <label for="mensagem">Mensagem</label>
                                <textarea id="mensagem" name="mensagem" rows="5" placeholder="Sua mensagem" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar mensagem</button>
                        </form>
                    </div>
                </div>
            </section>
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