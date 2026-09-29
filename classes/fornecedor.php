<?php

declare(strict_types=1);

class Fornecedor
{
    public function __construct(private PDO $conexao)
    {
    }

    public function cadastrar(string $nome, string $endereco, string $email, string $telefone): bool
    {
        $stmt = $this->conexao->prepare(
            'INSERT INTO fornecedores (nome, endereco, email, telefone)
             VALUES (:nome, :endereco, :email, :telefone)'
        );
        return $stmt->execute([
            ':nome' => $nome,
            ':endereco' => $endereco ?: null,
            ':email' => $email ?: null,
            ':telefone' => $telefone ?: null,
        ]);
    }

    public function listar(): array
    {
        return $this->conexao->query('SELECT * FROM fornecedores ORDER BY id DESC')->fetchAll();
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->conexao->prepare('DELETE FROM fornecedores WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}
