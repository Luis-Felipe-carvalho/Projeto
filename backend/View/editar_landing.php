<?php
require 'C:\Turma2\xampp\htdocs\Projeto-de-vida\config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Verifica se o usuário logado é o Eric
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$currentUser = $stmt->fetch();

if ($currentUser && $currentUser['username'] === 'Eric') {
    echo "<h2>Você não tem permissão para editar uma landing page.</h2>";
    exit;
}
// Busca landing page desse usuário
$stmt = $pdo->prepare("SELECT * FROM landing_pages WHERE user_id = ?");
$stmt->execute([$user_id]);
$landing = $stmt->fetch();

if (!$landing) {
    echo "<h2>Landing page ainda não foi criada por este usuário.</h2>";
    exit;
}
// Salvar ou atualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo_principal = $_POST['titulo_principal'];
    $sobre = $_POST['sobre'];
    $educacao = $_POST['educacao'];
    $carreira = $_POST['carreira'];
    $contato = $_POST['contato'];
    $publico = isset($_POST['publico']) ? 1 : 0;

    $stmt = $pdo->prepare("SELECT * FROM landing_pages WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $existente = $stmt->fetch();

    if ($existente) {
        $query = "UPDATE landing_pages SET titulo_principal=?, sobre=?, educacao=?, carreira=?, contato=?, publico=? WHERE user_id=?";
        $pdo->prepare($query)->execute([$titulo_principal, $sobre, $educacao, $carreira, $contato, $publico, $user_id]);
    } else {
        $query = "INSERT INTO landing_pages (user_id, titulo_principal, sobre, educacao, carreira, contato, publico) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $pdo->prepare($query)->execute([$user_id, $titulo_principal, $sobre, $educacao, $carreira, $contato, $publico]);
    }

    header('Location: landing.php?user_id=' . $user_id);
    exit;
}

// Carregar dados existentes
$stmt = $pdo->prepare("SELECT * FROM landing_pages WHERE user_id = ?");
$stmt->execute([$user_id]);
$landing = $stmt->fetch();
?>

<form method="POST">
    <input type="text" name="titulo_principal_principal" placeholder="Título" value="<?= htmlspecialchars($landing['titulo_principal_principal'] ?? '') ?>">
    <textarea name="sobre" placeholder="Sobre"><?= htmlspecialchars($landing['sobre'] ?? '') ?></textarea>
  <textarea name="subtitulo_principal" placeholder="subtitulo_principal"><?= htmlspecialchars($landing['subtitulo_principal'] ?? '') ?></textarea>
    <textarea name="educacao" placeholder="Educação"><?= htmlspecialchars($landing['educacao'] ?? '') ?></textarea>
    <textarea name="carreira" placeholder="Carreira"><?= htmlspecialchars($landing['carreira'] ?? '') ?></textarea>
    <textarea name="contato" placeholder="Contato"><?= htmlspecialchars($landing['contato'] ?? '') ?></textarea>
    <label><input type="checkbox" name="publico" <?= isset($landing['publico']) && $landing['publico'] ? 'checked' : '' ?>> Tornar público</label>
    <button type="submit">Salvar</button>
</form>