<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
require_once __DIR__ . '/../includes/view.php';
require_once __DIR__ . '/../classes/Cesta.php';

$cesta = new Cesta($conexao);
$cesta->buscarOuCriar(currentUserId());
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'remover') {
    $cesta->removerProduto((int) ($_POST['produto_id'] ?? 0));
    header('Location: cesta.php');
    exit;
}
$produtos = $cesta->listarProdutos();
$total = $cesta->calcularTotal($produtos);
renderHeader('Cesta', 'Cesta');
?>
<div class="d-flex justify-content-between align-items-center mb-4"><h1>Minha cesta</h1><span class="badge text-bg-primary"><?= count($produtos) ?> produto(s)</span></div>
<?php if (!$produtos): ?><div class="alert alert-info">Sua cesta está vazia. <a href="selecionar_produtos.php">Selecionar produtos</a>.</div><?php else: ?>
<div class="card shadow-sm"><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Produto</th><th>Preço</th><th>Ação</th></tr></thead><tbody>
<?php foreach ($produtos as $produto): ?><tr><td><?= e($produto['nome']) ?></td><td>R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></td><td><form method="post"><input type="hidden" name="acao" value="remover"><input type="hidden" name="produto_id" value="<?= (int) $produto['id'] ?>"><button class="btn btn-sm btn-outline-danger">Remover</button></form></td></tr><?php endforeach; ?></tbody></table></div><div class="summary-box"><p class="mb-1">Quantidade de produtos: <strong><?= count($produtos) ?></strong></p><p class="mb-0 fs-4">Valor total: <strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></p></div></div></div>
<?php endif; ?>
<?php renderFooter(); ?>