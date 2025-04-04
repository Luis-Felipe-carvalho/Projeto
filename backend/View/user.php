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
    </section>

    <script>
        document.getElementById("profile_picture").addEventListener("change", function() {
            document.getElementById("uploadForm").submit();
        });
    </script>

</body>

</html>