<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
require_once __DIR__ . '/../includes/view.php';
require_once __DIR__ . '/../classes/Cesta.php';
require_once __DIR__ . '/../classes/Produto.php';

$cesta = new Cesta($conexao);
$cesta->buscarOuCriar(currentUserId());
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selecionados = array_map('intval', $_POST['produtos'] ?? []);
    $selecionados = array_values(array_filter($selecionados, fn(int $id): bool => $id > 0));
    if (!$selecionados) {
        $erro = 'Selecione pelo menos um produto.';
    } else {
        foreach (array_unique($selecionados) as $produtoId) {
            $cesta->adicionarProduto($produtoId);
        }
        header('Location: cesta.php');
        exit;
    }
}
$produtos = (new Produto($conexao))->listar();
renderHeader('Selecionar produtos', 'Selecionar');
?>
<div class="d-flex justify-content-between align-items-center mb-4"><h1>Selecionar produtos</h1><span class="badge text-bg-success">Uma unidade por produto</span></div>
<?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>
<form method="post" id="formSelecao">
    <div class="row g-3">
    <?php foreach ($produtos as $produto): ?><div class="col-md-6 col-lg-4"><label class="product-select card shadow-sm h-100 p-3"><div class="form-check"><input class="form-check-input" type="checkbox" name="produtos[]" value="<?= (int) $produto['id'] ?>"><span class="form-check-label fw-semibold"><?= e($produto['nome']) ?></span></div><p class="text-muted small mb-1 mt-2"><?= e($produto['fornecedor_nome']) ?></p><strong>R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></strong></label></div><?php endforeach; ?>
    </div>
    <?php if (!$produtos): ?><p class="text-muted">Cadastre produtos antes de montar a cesta.</p><?php endif; ?>
    <button class="btn btn-primary mt-4" type="submit" <?= !$produtos ? 'disabled' : '' ?>>Adicionar à cesta</button>
</form>
<script>document.getElementById('formSelecao').addEventListener('submit', function (event) { if (!this.querySelectorAll('input[name="produtos[]"]:checked').length) { event.preventDefault(); alert('Selecione pelo menos um produto antes de continuar.'); } });</script>
<?php renderFooter(); ?>
