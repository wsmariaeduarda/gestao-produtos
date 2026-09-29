<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
require_once __DIR__ . '/../includes/view.php';
require_once __DIR__ . '/../classes/fornecedor.php';

$model = new Fornecedor($conexao);
$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    if ($acao === 'cadastrar') {
        $nome = trim($_POST['nome'] ?? '');
        if ($nome === '') {
            $erro = 'Informe o nome do fornecedor.';
        } else {
            $model->cadastrar($nome, trim($_POST['endereco'] ?? ''), trim($_POST['email'] ?? ''), trim($_POST['telefone'] ?? ''));
            $sucesso = 'Fornecedor cadastrado com sucesso.';
        }
    } elseif ($acao === 'excluir') {
        try {
            $model->excluir((int) ($_POST['id'] ?? 0));
            $sucesso = 'Fornecedor excluído com sucesso.';
        } catch (PDOException $e) {
            $erro = 'Não é possível excluir este fornecedor porque ele possui produtos vinculados.';
        }
    }
}
$fornecedores = $model->listar();
renderHeader('Fornecedores', 'Fornecedores');
?>
<div class="d-flex justify-content-between align-items-center mb-4"><h1>Fornecedores</h1><span class="badge text-bg-primary">Cadastro e listagem</span></div>
<?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>
<?php if ($sucesso): ?><div class="alert alert-success"><?= e($sucesso) ?></div><?php endif; ?>
<div class="card shadow-sm mb-4"><div class="card-body">
<form method="post" class="row g-3">
    <input type="hidden" name="acao" value="cadastrar">
    <div class="col-md-6"><label class="form-label">Nome *</label><input class="form-control" name="nome" required></div>
    <div class="col-md-6"><label class="form-label">Endereço</label><input class="form-control" name="endereco"></div>
    <div class="col-md-6"><label class="form-label">E-mail</label><input class="form-control" type="email" name="email"></div>
    <div class="col-md-6"><label class="form-label">Telefone</label><input class="form-control" name="telefone"></div>
    <div class="col-12"><button class="btn btn-primary" type="submit">Cadastrar fornecedor</button></div>
</form></div></div>
<div class="card shadow-sm"><div class="card-body"><h2 class="h4">Fornecedores cadastrados</h2><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Nome</th><th>Endereço</th><th>E-mail</th><th>Telefone</th><th>Ação</th></tr></thead><tbody>
<?php foreach ($fornecedores as $fornecedor): ?><tr><td><?= e($fornecedor['nome']) ?></td><td><?= e($fornecedor['endereco']) ?></td><td><?= e($fornecedor['email']) ?></td><td><?= e($fornecedor['telefone']) ?></td><td><form method="post" onsubmit="return confirm('Excluir este fornecedor?')"><input type="hidden" name="acao" value="excluir"><input type="hidden" name="id" value="<?= (int) $fornecedor['id'] ?>"><button class="btn btn-sm btn-outline-danger">Excluir</button></form></td></tr><?php endforeach; ?>
<?php if (!$fornecedores): ?><tr><td colspan="5" class="text-center">Nenhum fornecedor cadastrado.</td></tr><?php endif; ?></tbody></table></div></div></div>
<?php renderFooter(); ?>
