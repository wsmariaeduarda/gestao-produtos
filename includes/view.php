<?php

declare(strict_types=1);

function renderHeader(string $title, string $active = ''): void
{
    $links = [
        'Início' => 'index.php',
        'Produtos' => 'produtos.php',
        'Fornecedores' => 'fornecedores.php',
        'Selecionar' => 'selecionar_produtos.php',
        'Cesta' => 'cesta.php',
        'AJAX' => 'atualizacao_ajax.php',
    ];
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= e($title) ?> | GestProd</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark app-navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="index.php">GestProd</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuPrincipal">
                <div class="navbar-nav me-auto">
                    <?php foreach ($links as $label => $url): ?>
                        <a class="nav-link <?= $active === $label ? 'active' : '' ?>" href="<?= e($url) ?>"><?= e($label) ?></a>
                    <?php endforeach; ?>
                </div>
                <a class="btn btn-outline-light btn-sm" href="logout.php">Sair</a>
            </div>
        </div>
    </nav>
    <main class="container py-4">
    <?php
}

function renderFooter(): void
{
    ?>
    </main>
    <footer class="text-center text-muted py-4 small">Mini Sistema de Gestão de Produtos</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}
