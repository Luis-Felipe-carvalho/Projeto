<?php
// Verifica se a sessão já está ativa antes de iniciar
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Caminho correto para UserController.php
$controllerPath = __DIR__ . '/../Controller/UserController.php';

if (file_exists($controllerPath)) {
    require_once $controllerPath;
} else {
    die("Erro: Arquivo UserController.php não encontrado em $controllerPath");
}

// Caminho correto para o arquivo de configuração
$configPath = __DIR__ . '/../../config.php';

if (file_exists($configPath)) {
    require_once $configPath;
} else {
    die("Erro: Arquivo config.php não encontrado em $configPath");
}

// Verifica se a classe foi carregada corretamente
if (!class_exists('UserController')) {
    die("Erro: Classe UserController não encontrada. Verifique se o arquivo foi incluído corretamente.");
}

// Instancia o controlador
$Controller = new UserController($pdo);

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $Controller->getUserFromID($user_id)["username"];

// Buscar dados do usuário
$stmt = $pdo->prepare("SELECT username, email, description, profile_picture FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("Usuário não autenticado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_perfil_completo'])) {
    $fale = $_POST['fale_sobre_voce'] ?? '';
    $lembrancas = $_POST['minhas_lembrancas'] ?? '';
    $p_fortes = $_POST['pontos_fortes'] ?? '';
    $p_fracos = $_POST['pontos_fracos'] ?? '';
    $valores = $_POST['meus_valores'] ?? '';
    $aptidoes = implode(', ', $_POST['aptidoes'] ?? []);
    $rel_familia = $_POST['relacoes_familia'] ?? '';
    $rel_amigos = $_POST['relacoes_amigos'] ?? '';
    $rel_escola = $_POST['relacoes_escola'] ?? '';
    $rel_sociedade = $_POST['relacoes_sociedade'] ?? '';
    $gosto = $_POST['gosto_fazer'] ?? '';
    $nao_gosto = $_POST['nao_gosto_fazer'] ?? '';
    $rotina = $_POST['rotina'] ?? '';
    $lazer = $_POST['lazer'] ?? '';
    $estudos = $_POST['estudos'] ?? '';
    $vida_escolar = $_POST['vida_escolar'] ?? '';
    $visao_fisica = $_POST['visao_fisica'] ?? '';
    $visao_intelectual = $_POST['visao_intelectual'] ?? '';
    $visao_emocional = $_POST['visao_emocional'] ?? '';
    $visao_amigos = $_POST['visao_dos_amigos'] ?? '';
    $visao_familiares = $_POST['visao_dos_familiares'] ?? '';
    $visao_professores = $_POST['visao_dos_professores'] ?? '';
    $auto_total = (int) ($_POST['autovalorizacao_total'] ?? 0);

    $stmt = $pdo->prepare("INSERT INTO quem_sou_eu (
        user_id, fale_sobre_voce, minhas_lembrancas, pontos_fortes, pontos_fracos, meus_valores,
        principais_aptidoes, relacoes_familia, relacoes_amigos, relacoes_escola, relacoes_sociedade,
        gosto_fazer, nao_gosto_fazer, rotina, lazer, estudos, vida_escolar,
        visao_fisica, visao_intelectual, visao_emocional,
        visao_dos_amigos, visao_dos_familiares, visao_dos_professores, autovalorizacao_total
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $user_id, $fale, $lembrancas, $p_fortes, $p_fracos, $valores,
        $aptidoes, $rel_familia, $rel_amigos, $rel_escola, $rel_sociedade,
        $gosto, $nao_gosto, $rotina, $lazer, $estudos, $vida_escolar,
        $visao_fisica, $visao_intelectual, $visao_emocional,
        $visao_amigos, $visao_familiares, $visao_professores, $auto_total
    ]);

    header("Location: user.php?sucesso=1");
    exit;
}

// Upload de foto de perfil
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["profile_picture"])) {
    $file = $_FILES["profile_picture"];
    $uploadDir = __DIR__ . "/img/"; // Caminho absoluto para a pasta

    $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
    $fileType = mime_content_type($file["tmp_name"]);

    if ($file["error"] === 0 && in_array($fileType, $allowedTypes)) {
        // Criar diretório se não existir
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = uniqid() . "_" . basename($file["name"]);
        $filePath = "img/" . $fileName;

        if (move_uploaded_file($file["tmp_name"], $uploadDir . $fileName)) {
            $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->execute([$filePath, $user_id]);

            header("Location: user.php");
            exit();
        } else {
            echo "Erro ao mover o arquivo.";
        }
    } else {
        echo "Formato inválido. Use JPG, PNG ou GIF.";
    }



    if ($user_id === $logged_in) {
        die("Usuário autenticado.");
    }

    $fale = $_POST['fale_sobre_voce'] ?? '';
    $lembrancas = $_POST['minhas_lembrancas'] ?? '';
    $p_fortes = $_POST['pontos_fortes'] ?? '';
    $p_fracos = $_POST['pontos_fracos'] ?? '';
    $valores = $_POST['meus_valores'] ?? '';
    $aptidoes = implode(', ', $_POST['aptidoes'] ?? []);


    $stmt = $pdo->prepare("INSERT INTO quem_sou_eu (user_id, fale_sobre_voce, minhas_lembrancas, pontos_fortes, pontos_fracos, meus_valores, principais_aptidoes) 
VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $fale, $lembrancas, $p_fortes, $p_fracos, $valores, $aptidoes]);

    header("Location: user.php");
    exit;
}

$profilePicture = !empty($user['profile_picture']) ? $user['profile_picture'] : "img/default.png";
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

<body>

    <header id="navbar">
        <div class="container">
            <a href="index.php" class="logo">Projeto de <span>Vida</span></a>
            <nav>
                <ul class="desktop-nav">
                    <li><a href="index.php">Início</a></li>
                    <li><a href="index.php">Sobre</a></li>
                    <li><a href="index.php">Educação</a></li>
                    <li><a href="index.php">Carreira</a></li>
                    <li><a href="index.php">Contato</a></li>
                    <li><a href="user.php">Perfil</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="profile-container">
        <div class="profile-pic-container">
            <img src="<?= htmlspecialchars($profilePicture) ?>" alt="Foto de Perfil">

            <div class="upload-overlay">
                <label for="profile_picture">Alterar Foto</label>
            </div>

            <form method="POST" action="user.php" enctype="multipart/form-data" id="uploadForm">
                <input type="file" id="profile_picture" name="profile_picture" required>
                <button type="submit" class="upload-btn">Enviar</button>
            </form>
        </div>

        <!-- Informações do usuário -->
        <div class="user-info">
            <?php if ($authType === 'normal'): ?>
                <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_usuario'])) {
                    $new_name = trim($_POST['nome']);
                    $new_email = trim($_POST['email']);

                    if (!empty($new_nome) && !empty($new_email)) {
                        $stmt = $pdo->prepare("UPDATE users SET nome = ?, email = ? WHERE id = ?");
                        if ($stmt->execute([$new_nome, $new_email, $user['id']])) {
                            $username = $new_nome;
                            $user['email'] = $new_email;
                            echo "<p style='color: green;'>Dados atualizados com sucesso.</p>";
                        } else {
                            echo "<p style='color: red;'>Erro ao atualizar dados.</p>";
                        }
                    } else {
                        echo "<p style='color: red;'>Preencha todos os campos.</p>";
                    }
                }
                ?>

                <form method="POST">
                    <h2>Nome de Usuário:</h2>
                    <input type="text" name="nome" value="<?= htmlspecialchars($username) ?>">

                    <h2>Email:</h2>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">

                    <button type="submit" name="edit_usuario" class="btn">Salvar Alterações</button>
                </form>

            <?php elseif ($authType === 'google' && isset($info)): ?>
                <h2>Nome de Usuário: <?= htmlspecialchars($info['name'] ?? 'Nome não disponível') ?></h2>
                <h2>Email: <?= htmlspecialchars($info['email'] ?? 'Email não disponível') ?></h2>
            <?php else: ?>
                <h2>Nome de Usuário: Não disponível</h2>
                <h2>Email: Não disponível</h2>
            <?php endif; ?>

            <a href="logout.php"><button class="logout-button">Sair da conta</button></a>
        </div>

        <!-- Descrição -->
        <h3>Descrição:</h3>
        <form method="POST">
            <textarea name="description" rows="5"><?= htmlspecialchars($user['description'] ?? '') ?></textarea>
            <button type="submit">Salvar</button>
        </form>


        <!-- Formulário "Quem Sou Eu?" -->
        <h3>Quem Sou Eu?</h3>
        <form method="POST">
    <h3>Fale sobre você</h3>
    <textarea name="fale_sobre_voce" rows="4"></textarea>

    <h3>Minhas Lembranças</h3>
    <textarea name="minhas_lembrancas" rows="4"></textarea>

    <h3>Pontos Fortes</h3>
    <input type="text" name="pontos_fortes">

    <h3>Pontos Fracos</h3>
    <input type="text" name="pontos_fracos">

    <h3>Meus Valores</h3>
    <input type="text" name="meus_valores">

    <h3>Minhas Principais Aptidões</h3>
    <label><input type="checkbox" name="aptidoes[]" value="Comunicativo"> Comunicativo</label>
    <label><input type="checkbox" name="aptidoes[]" value="Criativo"> Criativo</label>
    <label><input type="checkbox" name="aptidoes[]" value="Organizado"> Organizado</label>

    <h3>Meus Relacionamentos</h3>
    <label>Família</label><input type="text" name="relacoes_familia">
    <label>Amigos</label><input type="text" name="relacoes_amigos">
    <label>Escola</label><input type="text" name="relacoes_escola">
    <label>Sociedade</label><input type="text" name="relacoes_sociedade">

    <h3>Meu Dia a Dia</h3>
    <label>O que gosto de fazer</label><input type="text" name="gosto_fazer">
    <label>O que não gosto</label><input type="text" name="nao_gosto_fazer">
    <label>Rotina</label><input type="text" name="rotina">
    <label>Lazer</label><input type="text" name="lazer">
    <label>Estudos</label><input type="text" name="estudos">

    <h3>Minha Vida Escolar</h3>
    <textarea name="vida_escolar" rows="3"></textarea>

    <h3>Minha Visão Sobre Mim</h3>
    <label>Física</label><input type="text" name="visao_fisica">
    <label>Intelectual</label><input type="text" name="visao_intelectual">
    <label>Emocional</label><input type="text" name="visao_emocional">

    <h3>A Visão das Pessoas Sobre Mim</h3>
    <label>Amigos</label><input type="text" name="visao_dos_amigos">
    <label>Familiares</label><input type="text" name="visao_dos_familiares">
    <label>Professores</label><input type="text" name="visao_dos_professores">

    <h3>Autovalorização</h3>
    <label>Total (preenchido automaticamente por JS ou manualmente)</label>
    <input type="number" name="autovalorizacao_total" min="0" max="100">

    <br><br>
    <button type="submit" name="salvar_perfil_completo">Salvar Tudo</button>
</form>

    </section>

    <script>
        document.getElementById("profile_picture").addEventListener("change", function() {
            document.getElementById("uploadForm").submit();
        });
    </script>

</body>

</html>