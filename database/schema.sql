CREATE DATABASE IF NOT EXISTS gestao_produtos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gestao_produtos;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(20) NULL,
    senha VARCHAR(64) NOT NULL
);

CREATE TABLE IF NOT EXISTS fornecedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(200) NULL,
    email VARCHAR(100) NULL,
    telefone VARCHAR(20) NULL
);

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    fornecedor_id INT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    descricao TEXT NULL,
    img VARCHAR(255) NULL,
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)
);

CREATE TABLE IF NOT EXISTS cestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS cesta_produtos (
    cesta_id INT NOT NULL,
    produto_id INT NOT NULL,
    PRIMARY KEY (cesta_id, produto_id),
    FOREIGN KEY (cesta_id) REFERENCES cestas(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);
