<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
require_once __DIR__ . '/../classes/Produto.php';

$id = (int) ($_GET['id'] ?? 0);
$model = new Produto($conexao);
$model->excluir($id);
header('Location: produtos.php');
exit;
