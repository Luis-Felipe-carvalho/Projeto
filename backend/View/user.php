<?php
session_start();
include_once '../Controller/UserController.php';
include_once 'C:/Turma2/xampp/htdocs/Projeto-de-vida/config.php';

$Controller = new UserController($pdo);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
$username = $Controller->getUserFromID($_SESSION['user_id'])["username"];

$user_id = $_SESSION['user_id'];

// Buscar dados do usuário
$stmt = $pdo->prepare("SELECT username, email, description, profile_picture FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado.");
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['description'])) {
    $new_description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE users SET description = ? WHERE id = ?");
    $stmt->execute([$new_description, $user_id]);

    header("Location: user.php");
    exit();
}

//foto-perfil
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_picture"])) {
    $file = $_FILES["profile_picture"];
    $uploadDir = __DIR__ . "\img\\"; // Caminho absoluto para a pasta

    $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
    $fileType = mime_content_type($file["tmp_name"]); // Obtém o tipo do arquivo

    if ($file["error"] === 0 && in_array($fileType, $allowedTypes)) {
        // Criar diretório se não existir
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = uniqid() . "_" . basename($file["name"]);
        $filePath = "img/" . $fileName; // Caminho relativo para salvar no banco

        if (move_uploaded_file($file["tmp_name"], $uploadDir . $fileName)) {
            // Salva o caminho no banco
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

<style>
    img {
        border-radius: 100px;
    }
</style>

<body>

    <!-- Navigation -->
    <header id="navbar">
        <div class="container">
            <a href="../../backend/View/index.php" class="logo">Projeto de <span>Vida</span></a>
            <nav>
                <ul class="desktop-nav">
                    <li><a href="index.php?#Inicio">Início</a></li>
                    <li><a href="index.php?#Sobre">Sobre</a></li>
                    <li><a href="index.php?#Educacao">Educação</a></li>
                    <li><a href="index.php?#Carreira">Carreira</a></li>
                    <li><a href="index.php?#Contato">Contato</a></li>
                    <li><a href="user.php">Perfil</a></li>
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




















    <style>
        /* Contêiner principal */
        .profile-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        /* Foto de perfil */
        .profile-pic-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #bfdbfe;
        }

        .profile-pic-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Botão de upload sobreposto */
        .upload-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .profile-pic-container:hover .upload-overlay {
            opacity: 1;
        }

        .upload-overlay label {
            cursor: pointer;
            color: white;
            font-size: 14px;
            background: #00000080;
            padding: 8px 12px;
            border-radius: 5px;
        }

        input[type="file"] {
            display: none;
        }

        /* Informações do usuário */
        .user-info {
            margin-top: 20px;
        }

        .user-info h2 {
            font-size: 18px;
            margin: 5px 0;
            color: #333;
        }

        /* Área de descrição */
        textarea {
            width: 100%;
            min-height: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Botões */
        button {
            background: #3b82f6;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        button:hover {
            background: #2563eb;
        }

        /* Botão de logout */
        .logout-button {
            background: #dc2626;
            margin-top: 10px;
        }

        .logout-button:hover {
            background: #b91c1c;
        }
    </style>


    <section class="profile-container">
    <div class="profile-pic-container">
            <img src="<?= htmlspecialchars($profilePicture) ?>" alt="Foto de Perfil">

            <!-- Overlay para upload -->
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
            <h2>Nome de Usuário: <?= htmlspecialchars($username) ?></h2>
            <h2>Email: <?= htmlspecialchars($_SESSION['email']) ?></h2>
            <a href="logout.php"><button class="logout-button">Sair da conta</button></a>
        </div>

        <!-- Descrição -->
        <h3>Descrição:</h3>
        <form method="POST">
            <textarea name="description" rows="5"><?= htmlspecialchars($user['description']) ?></textarea>
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