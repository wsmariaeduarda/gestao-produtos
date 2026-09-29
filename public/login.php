<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/usuario.php';

if (!empty($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $usuarioModel = new Usuario($conexao);
    $usuario = $usuarioModel->login($email, $senha);

    if ($usuario) {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = (int) $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header('Location: index.php');
        exit;
    }
    $erro = 'E-mail ou senha incorretos.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GestProd</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
<div class="auth-card">
    <h1 class="h3 mb-2">GestProd</h1>
    <p class="text-muted mb-4">Entre para gerenciar produtos e cestas.</p>
    <?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>
    <form method="post" novalidate>
        <label class="form-label" for="email">E-mail</label>
        <input class="form-control mb-3" id="email" type="email" name="email" required>
        <label class="form-label" for="senha">Senha</label>
        <input class="form-control mb-3" id="senha" type="password" name="senha" minlength="6" required>
        <button class="btn btn-primary w-100" type="submit">Entrar</button>
    </form>
    <a class="btn btn-outline-secondary w-100 mt-3" href="cadastro.php">Criar uma conta</a>
</div>
</body>
</html>
