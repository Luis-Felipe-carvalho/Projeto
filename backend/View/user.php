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

if (!$user) {
    die("Usuário não encontrado.");
}

// Definir auth_type com valor padrão para evitar erro de índice indefinido
$authType = $_SESSION['auth_type'] ?? 'normal';

// Atualizar descrição do usuário
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['description'])) {
    $new_description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE users SET description = ? WHERE id = ?");
    $stmt->execute([$new_description, $user_id]);

    header("Location: user.php");
    exit();
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
        <form method="POST" action="user.php">
            <!-- Fale sobre você -->
            <label for="sobre_voce">Fale sobre você:</label>
            <textarea name="sobre_voce" rows="4"><?= htmlspecialchars($user['sobre_voce'] ?? '') ?></textarea>

            <!-- Minhas Lembranças -->
            <label for="lembrancas">Minhas Lembranças:</label>
            <textarea name="lembrancas" rows="4"><?= htmlspecialchars($user['lembrancas'] ?? '') ?></textarea>

            <!-- Pontos Fortes e Fracos -->
            <label for="pontos_fortes">Pontos Fortes:</label>
            <input type="text" name="pontos_fortes" value="<?= htmlspecialchars($user['pontos_fortes'] ?? '') ?>">

            <label for="pontos_fracos">Pontos Fracos:</label>
            <input type="text" name="pontos_fracos" value="<?= htmlspecialchars($user['pontos_fracos'] ?? '') ?>">

            <!-- Meus Valores -->
            <label for="valores">Meus Valores (separar por vírgula):</label>
            <input type="text" name="valores" value="<?= htmlspecialchars($user['valores'] ?? '') ?>">

            <!-- Aptidões -->
            <label>Minhas Principais Aptidões:</label><br>
            <?php
            $aptidoes = ['Liderança', 'Empatia', 'Organização', 'Criatividade', 'Comunicação'];
            foreach ($aptidoes as $apt) {
                $checked = (isset($user['aptidoes']) && in_array($apt, explode(',', $user['aptidoes']))) ? 'checked' : '';
                echo "<label><input type='checkbox' name='aptidoes[]' value='$apt' $checked> $apt</label><br>";
            }
            ?>

            <!-- Relacionamentos -->
            <label for="familia">Família:</label>
            <input type="text" name="familia" value="<?= htmlspecialchars($user['familia'] ?? '') ?>">

            <label for="amigos">Amigos:</label>
            <input type="text" name="amigos" value="<?= htmlspecialchars($user['amigos'] ?? '') ?>">

            <label for="escola">Escola:</label>
            <input type="text" name="escola" value="<?= htmlspecialchars($user['escola'] ?? '') ?>">

            <label for="sociedade">Sociedade:</label>
            <input type="text" name="sociedade" value="<?= htmlspecialchars($user['sociedade'] ?? '') ?>">

            <!-- Meu Dia a Dia -->
            <label for="gosto_fazer">O que gosto de fazer:</label>
            <input type="text" name="gosto_fazer" value="<?= htmlspecialchars($user['gosto_fazer'] ?? '') ?>">

            <label for="nao_gosto">O que não gosto:</label>
            <input type="text" name="nao_gosto" value="<?= htmlspecialchars($user['nao_gosto'] ?? '') ?>">

            <label for="rotina">Rotina:</label>
            <input type="text" name="rotina" value="<?= htmlspecialchars($user['rotina'] ?? '') ?>">

            <label for="lazer">Lazer:</label>
            <input type="text" name="lazer" value="<?= htmlspecialchars($user['lazer'] ?? '') ?>">

            <label for="estudos">Estudos:</label>
            <input type="text" name="estudos" value="<?= htmlspecialchars($user['estudos'] ?? '') ?>">

            <!-- Vida Escolar -->
            <label for="vida_escolar">Minha Vida Escolar:</label>
            <textarea name="vida_escolar" rows="3"><?= htmlspecialchars($user['vida_escolar'] ?? '') ?></textarea>

            <!-- Minha Visão Sobre Mim -->
            <label for="visao_fisica">Visão Física:</label>
            <input type="text" name="visao_fisica" value="<?= htmlspecialchars($user['visao_fisica'] ?? '') ?>">

            <label for="visao_intelectual">Visão Intelectual:</label>
            <input type="text" name="visao_intelectual" value="<?= htmlspecialchars($user['visao_intelectual'] ?? '') ?>">

            <label for="visao_emocional">Visão Emocional:</label>
            <input type="text" name="visao_emocional" value="<?= htmlspecialchars($user['visao_emocional'] ?? '') ?>">

            <!-- Visão das Pessoas Sobre Mim -->
            <label for="visao_amigos">O que meus amigos dizem:</label>
            <input type="text" name="visao_amigos" value="<?= htmlspecialchars($user['visao_amigos'] ?? '') ?>">

            <label for="visao_familiares">O que minha família diz:</label>
            <input type="text" name="visao_familiares" value="<?= htmlspecialchars($user['visao_familiares'] ?? '') ?>">

            <label for="visao_professores">O que meus professores dizem:</label>
            <input type="text" name="visao_professores" value="<?= htmlspecialchars($user['visao_professores'] ?? '') ?>">

            <!-- Autovalorização (exemplo simplificado) -->
            <label for="autovalorizacao">Como você se sente sobre você mesmo(a)?</label>
            <select name="autovalorizacao">
                <option value="1" <?= ($user['autovalorizacao'] ?? '') == '1' ? 'selected' : '' ?>>1 - Muito Ruim</option>
                <option value="2" <?= ($user['autovalorizacao'] ?? '') == '2' ? 'selected' : '' ?>>2 - Ruim</option>
                <option value="3" <?= ($user['autovalorizacao'] ?? '') == '3' ? 'selected' : '' ?>>3 - Regular</option>
                <option value="4" <?= ($user['autovalorizacao'] ?? '') == '4' ? 'selected' : '' ?>>4 - Alto</option>
                <option value="5" <?= ($user['autovalorizacao'] ?? '') == '5' ? 'selected' : '' ?>>5 - Excelente</option>
            </select>

            <button type="submit">Salvar Formulário</button>
        </form>

    </section>

    <script>
        document.getElementById("profile_picture").addEventListener("change", function() {
            document.getElementById("uploadForm").submit();
        });
    </script>

</body>

</html>