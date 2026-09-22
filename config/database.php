<?php

$host = "localhost";
$dbname = "gestao_produtos";
$user = "root";
$senha = "";

try {
    $conexao = new PDO("mysql:host=$host", $user, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

$conexao->exec("CREATE DATABASE IF NOT EXISTS $dbname");
$conexao->exec("USE $dbname");
$conexao->exec("
    CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        telefone VARCHAR(20),
        senha VARCHAR(255) NOT NULL
    )
");
$conexao->exec("
    CREATE TABLE IF NOT EXISTS fornecedores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        endereco VARCHAR(200),
        email VARCHAR(100),
        telefone VARCHAR(20)
    )
");
$conexao->exec("
    CREATE TABLE IF NOT EXISTS produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        fornecedor_id INT NOT NULL,
        preco DECIMAL(10,2) NOT NULL,
        descricao TEXT,
        img VARCHAR(255),
        FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)
    )
");
$conexao->exec("
    CREATE TABLE IF NOT EXISTS cestas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )
");
$conexao->exec("
    CREATE TABLE IF NOT EXISTS cesta_produtos (
        cesta_id INT NOT NULL,
        produto_id INT NOT NULL,
        PRIMARY KEY (cesta_id, produto_id),
        FOREIGN KEY (cesta_id) REFERENCES cestas(id),
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
    )
");