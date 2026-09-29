<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
require_once __DIR__ . '/../includes/view.php';
require_once __DIR__ . '/../classes/Produto.php';
require_once __DIR__ . '/../classes/fornecedor.php';
require_once __DIR__ . '/../classes/Cesta.php';

$produtos = (new Produto($conexao))->listar();
$fornecedores = (new Fornecedor($conexao))->listar();
$cestaModel = new Cesta($conexao);
$cestaModel->buscarOuCriar(currentUserId());
$produtosCesta = $cestaModel->listarProdutos();
$nome = $_SESSION['usuario_nome'] ?? 'usuário';

renderHeader('Início', 'Início');
?>
<section class="hero mb-4">
    <h1 class="display-6 fw-bold">Olá, <?= e($nome) ?>!</h1>
    <p class="text-muted">Bem-vindo ao painel de gestão de produtos.</p>
</section>
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="stat-card"><span>Produtos</span><strong><?= count($produtos) ?></strong></div></div>
    <div class="col-md-4"><div class="stat-card"><span>Fornecedores</span><strong><?= count($fornecedores) ?></strong></div></div>
    <div class="col-md-4"><div class="stat-card"><span>Na cesta</span><strong><?= count($produtosCesta) ?></strong></div></div>
</div>
<div class="row g-3">
    <div class="col-md-4"><a class="quick-card" href="fornecedores.php"><h2>Fornecedores</h2><p>Cadastre e gerencie fornecedores.</p></a></div>
    <div class="col-md-4"><a class="quick-card" href="produtos.php"><h2>Produtos</h2><p>Cadastre produtos e associe fornecedores.</p></a></div>
    <div class="col-md-4"><a class="quick-card" href="selecionar_produtos.php"><h2>Cesta</h2><p>Selecione produtos e consulte o resumo.</p></a></div>
</div>
<?php renderFooter(); ?>
