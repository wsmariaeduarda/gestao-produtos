<?php
require_once __DIR__ . '/../../includes/auth.php';
requireLogin();

header('Content-Type: application/json; charset=utf-8');

try {
    $usuarios = $conexao->query('SELECT id, nome, email FROM usuarios ORDER BY id DESC')->fetchAll();
    $fornecedores = $conexao->query('SELECT id, nome, email FROM fornecedores ORDER BY id DESC')->fetchAll();
    $produtos = $conexao->query(
        'SELECT p.id, p.nome, p.preco, f.nome AS fornecedor
         FROM produtos p INNER JOIN fornecedores f ON f.id = p.fornecedor_id
         ORDER BY p.id DESC'
    )->fetchAll();

    echo json_encode([
        'ok' => true,
        'usuarios' => $usuarios,
        'fornecedores' => $fornecedores,
        'produtos' => $produtos,
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Não foi possível consultar os dados.'], JSON_UNESCAPED_UNICODE);
}
