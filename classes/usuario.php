<?php

declare(strict_types=1);

class Usuario
{
    public function __construct(private PDO $conexao)
    {
    }

    public function criar(string $nome, string $email, string $telefone, string $senha): bool
    {
        $hash = hash('sha256', $senha);
        $stmt = $this->conexao->prepare(
            'INSERT INTO usuarios (nome, email, telefone, senha)
             VALUES (:nome, :email, :telefone, :senha)'
        );
        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':telefone' => $telefone ?: null,
            ':senha' => $hash,
        ]);
    }

    public function existePorEmail(string $email): bool
    {
        $stmt = $this->conexao->prepare('SELECT id FROM usuarios WHERE email = :email');
        $stmt->execute([':email' => $email]);
        return (bool) $stmt->fetchColumn();
    }

    public function login(string $email, string $senha): array|false
    {
        $hash = hash('sha256', $senha);
        $stmt = $this->conexao->prepare(
            'SELECT * FROM usuarios WHERE email = :email AND senha = :senha LIMIT 1'
        );
        $stmt->execute([':email' => $email, ':senha' => $hash]);
        return $stmt->fetch() ?: false;
    }

    public function buscarPorId(int $id): array|false
    {
        $stmt = $this->conexao->prepare('SELECT * FROM usuarios WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: false;
    }

    public function listar(): array
    {
        return $this->conexao->query('SELECT id, nome, email, telefone FROM usuarios ORDER BY id DESC')->fetchAll();
    }
}
