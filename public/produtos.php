<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
require_once __DIR__ . '/../includes/view.php';
require_once __DIR__ . '/../classes/Produto.php';
require_once __DIR__ . '/../classes/fornecedor.php';

$produtoModel = new Produto($conexao);
$fornecedorModel = new Fornecedor($conexao);
$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    if ($acao === 'cadastrar') {
        $nome = trim($_POST['nome'] ?? '');
        $fornecedorId = (int) ($_POST['fornecedor_id'] ?? 0);
        $preco = (float) ($_POST['preco'] ?? 0);
        $descricao = trim($_POST['descricao'] ?? '');
        if ($nome === '' || $fornecedorId <= 0 || $preco <= 0) {
            $erro = 'Preencha nome, fornecedor e preço maior que zero.';
        } else {
            $produtoModel->cadastrar($nome, $fornecedorId, $preco, $descricao, trim($_POST['img'] ?? ''));
            $sucesso = 'Produto cadastrado com sucesso.';
        }
    } elseif ($acao === 'excluir') {
        if ($produtoModel->excluir((int) ($_POST['id'] ?? 0))) {
            $sucesso = 'Produto excluído com sucesso.';
        } else {
            $erro = 'Este produto está em uma cesta e não pode ser excluído.';
        }
    }
}
$fornecedores = $fornecedorModel->listar();
$produtos = $produtoModel->listar();
renderHeader('Produtos', 'Produtos');
?>
<div class="d-flex justify-content-between align-items-center mb-4"><h1>Produtos</h1><span class="badge text-bg-primary">Cadastro e listagem</span></div>
<?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>
<?php if ($sucesso): ?><div class="alert alert-success"><?= e($sucesso) ?></div><?php endif; ?>
<div class="card shadow-sm mb-4"><div class="card-body">
<form method="post" class="row g-3">
    <input type="hidden" name="acao" value="cadastrar">
    <div class="col-md-6"><label class="form-label">Nome *</label><input class="form-control" name="nome" required></div>
    <div class="col-md-6"><label class="form-label">Fornecedor *</label><select class="form-select" name="fornecedor_id" required><option value="">Selecione</option><?php foreach ($fornecedores as $f): ?><option value="<?= (int) $f['id'] ?>"><?= e($f['nome']) ?></option><?php endforeach; ?></select></div>
    <div class="col-md-4"><label class="form-label">Preço *</label><input class="form-control" type="number" name="preco" min="0.01" step="0.01" required></div>
    <div class="col-md-8"><label class="form-label">Imagem (URL opcional)</label><input class="form-control" name="img" type="url"></div>
    <div class="col-12"><label class="form-label">Descrição</label><textarea class="form-control" name="descricao" rows="3"></textarea></div>
    <div class="col-12"><button class="btn btn-primary" type="submit">Cadastrar produto</button></div>
</form></div></div>
<div class="card shadow-sm"><div class="card-body"><h2 class="h4">Produtos cadastrados</h2><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Nome</th><th>Fornecedor</th><th>Preço</th><th>Descrição</th><th>Ação</th></tr></thead><tbody>
<?php foreach ($produtos as $produto): ?><tr><td><?= e($produto['nome']) ?></td><td><?= e($produto['fornecedor_nome']) ?></td><td>R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></td><td><?= e($produto['descricao']) ?></td><td><form method="post" onsubmit="return confirm('Excluir este produto?')"><input type="hidden" name="acao" value="excluir"><input type="hidden" name="id" value="<?= (int) $produto['id'] ?>"><button class="btn btn-sm btn-outline-danger">Excluir</button></form></td></tr><?php endforeach; ?>
<?php if (!$produtos): ?><tr><td colspan="5" class="text-center">Nenhum produto cadastrado.</td></tr><?php endif; ?></tbody></table></div></div></div>
<?php renderFooter(); ?>
