<?php

declare(strict_types=1);

$host = 'localhost';
$dbname = 'gestao_produtos';
$user = 'root';
$senha = '';

try {
    $conexao = new PDO(
        "mysql:host={$host};charset=utf8mb4",
        $user,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    $conexao->exec(
        "CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
    );
    $conexao->exec("USE `{$dbname}`");

    $conexao->exec(<<<SQL
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            telefone VARCHAR(20) NULL,
            senha VARCHAR(64) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    SQL);

    $conexao->exec(<<<SQL
        CREATE TABLE IF NOT EXISTS fornecedores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            endereco VARCHAR(200) NULL,
            email VARCHAR(100) NULL,
            telefone VARCHAR(20) NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    SQL);

    $conexao->exec(<<<SQL
        CREATE TABLE IF NOT EXISTS produtos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            fornecedor_id INT NOT NULL,
            preco DECIMAL(10,2) NOT NULL,
            descricao TEXT NULL,
            img VARCHAR(255) NULL,
            CONSTRAINT fk_produtos_fornecedores
                FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)
                ON UPDATE CASCADE ON DELETE RESTRICT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    SQL);

    $conexao->exec(<<<SQL
        CREATE TABLE IF NOT EXISTS cestas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT NOT NULL UNIQUE,
            CONSTRAINT fk_cestas_usuarios
                FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
                ON UPDATE CASCADE ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    SQL);

    $conexao->exec(<<<SQL
        CREATE TABLE IF NOT EXISTS cesta_produtos (
            cesta_id INT NOT NULL,
            produto_id INT NOT NULL,
            PRIMARY KEY (cesta_id, produto_id),
            CONSTRAINT fk_cesta_produtos_cestas
                FOREIGN KEY (cesta_id) REFERENCES cestas(id)
                ON UPDATE CASCADE ON DELETE CASCADE,
            CONSTRAINT fk_cesta_produtos_produtos
                FOREIGN KEY (produto_id) REFERENCES produtos(id)
                ON UPDATE CASCADE ON DELETE RESTRICT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    SQL);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Erro ao conectar ou preparar o banco de dados. Verifique se o MySQL está ativo no XAMPP.');