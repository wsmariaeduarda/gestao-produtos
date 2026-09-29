<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/usuario.php';

$erro = '';
$sucesso = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmacao = $_POST['confirmacao'] ?? '';
    $usuarioModel = new Usuario($conexao);

    if ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($senha) < 6) {
        $erro = 'Preencha nome, e-mail válido e senha com pelo menos 6 caracteres.';
    } elseif ($senha !== $confirmacao) {
        $erro = 'As senhas não conferem.';
    } elseif ($usuarioModel->existePorEmail($email)) {
        $erro = 'Este e-mail já está cadastrado.';
    } else {
        try {
            $usuarioModel->criar($nome, $email, $telefone, $senha);
            $sucesso = 'Cadastro realizado! Agora você pode entrar.';
        } catch (PDOException $e) {
            $erro = 'Não foi possível realizar o cadastro.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta | GestProd</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
<div class="auth-card">
    <h1 class="h3 mb-2">Criar conta</h1>
    <p class="text-muted mb-4">Cadastre-se para utilizar o sistema.</p>
    <?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>
    <?php if ($sucesso): ?><div class="alert alert-success"><?= e($sucesso) ?></div><?php endif; ?>
    <form method="post">
        <label class="form-label" for="nome">Nome</label>
        <input class="form-control mb-3" id="nome" type="text" name="nome" required>
        <label class="form-label" for="email">E-mail</label>
        <input class="form-control mb-3" id="email" type="email" name="email" required>
        <label class="form-label" for="telefone">Telefone</label>
        <input class="form-control mb-3" id="telefone" type="text" name="telefone">
        <label class="form-label" for="senha">Senha</label>
        <input class="form-control mb-3" id="senha" type="password" name="senha" minlength="6" required>
        <label class="form-label" for="confirmacao">Confirmar senha</label>
        <input class="form-control mb-3" id="confirmacao" type="password" name="confirmacao" minlength="6" required>
        <button class="btn btn-primary w-100" type="submit">Cadastrar</button>
    </form>
    <a class="btn btn-outline-secondary w-100 mt-3" href="login.php">Voltar ao login</a>
</div>
</body>
</html>