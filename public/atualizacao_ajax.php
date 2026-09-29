<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
require_once __DIR__ . '/../includes/view.php';
renderHeader('Atualização AJAX', 'AJAX');
?>
<div class="d-flex justify-content-between align-items-center mb-4"><h1>Atualização com AJAX</h1><span class="badge text-bg-info">Atualização automática</span></div>
<p class="text-muted">Os dados abaixo são consultados pela API a cada 3 segundos sem recarregar a página.</p>
<div id="ajaxStatus" class="alert alert-secondary">Carregando dados...</div>
<div class="row g-4">
    <div class="col-lg-4"><div class="card shadow-sm h-100"><div class="card-body"><h2 class="h5">Usuários</h2><div id="usuarios"></div></div></div></div>
    <div class="col-lg-4"><div class="card shadow-sm h-100"><div class="card-body"><h2 class="h5">Fornecedores</h2><div id="fornecedores"></div></div></div></div>
    <div class="col-lg-4"><div class="card shadow-sm h-100"><div class="card-body"><h2 class="h5">Produtos</h2><div id="produtos"></div></div></div></div>
</div>
<script src="js/ajax.js" defer></script>
<?php renderFooter(); ?>