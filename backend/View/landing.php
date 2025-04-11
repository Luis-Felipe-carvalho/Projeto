<?php
require 'C:\Turma2\xampp\htdocs\Projeto-de-vida\config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Acesso não autorizado.";
    exit;
}

$user_id = $_SESSION['user_id']; // ✅ Definindo a variável corretamente

// Carregar landing existente
$stmt = $pdo->prepare("SELECT * FROM landing_pages WHERE user_id = ?");
$stmt->execute([$user_id]);
$landing = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo_principal = $_POST['titulo_principal'];
    $subtitulo = $_POST['subtitulo'];
    $sobre = $_POST['sobre'];
    $educacao = $_POST['educacao'];
    $carreira = $_POST['carreira'];
    $contato = $_POST['contato'];

    if ($landing) {
        $stmt = $pdo->prepare("UPDATE landing_pages SET titulo_principal = ?, subtitulo = ?, sobre = ?, educacao = ?, carreira = ?, contato = ? WHERE user_id = ?");
        $stmt->execute([$titulo_principal, $subtitulo, $sobre, $educacao, $carreira, $contato, $user_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO landing_pages (user_id, titulo_principal, subtitulo, sobre, educacao, carreira, contato) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $titulo_principal, $subtitulo, $sobre, $educacao, $carreira, $contato]);
    }

    echo "<p style='color: green;'>Landing page atualizada com sucesso!</p>";
    
    // Recarregar dados atualizados
    $stmt = $pdo->prepare("SELECT * FROM landing_pages WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $landing = $stmt->fetch();

    header("Location: user.php");
}
?>

<h2>Editar Minha Landing Page</h2>
<form method="POST">
    <label>Título Principal</label>
    <input type="text" name="titulo_principal" value="<?= htmlspecialchars($landing['titulo_principal'] ?? '') ?>"><br>

    <label>Subtítulo</label>
    <textarea name="subtitulo" rows="2"><?= htmlspecialchars($landing['subtitulo'] ?? '') ?></textarea><br>

    <label>Sobre</label>
    <textarea name="sobre" rows="4"><?= htmlspecialchars($landing['sobre'] ?? '') ?></textarea><br>

    <label>Educação</label>
    <textarea name="educacao" rows="4"><?= htmlspecialchars($landing['educacao'] ?? '') ?></textarea><br>

    <label>Carreira</label>
    <textarea name="carreira" rows="4"><?= htmlspecialchars($landing['carreira'] ?? '') ?></textarea><br>

    <label>Contato</label>
    <textarea name="contato" rows="4"><?= htmlspecialchars($landing['contato'] ?? '') ?></textarea><br>

    <button type="submit">Salvar Landing Page</button>
</form>
