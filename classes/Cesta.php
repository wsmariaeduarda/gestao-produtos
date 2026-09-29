<?php

declare(strict_types=1);

class Cesta
{
    private ?int $id = null;

    public function __construct(private PDO $conexao)
    {
    }

    public function buscarOuCriar(int $usuarioId): int
    {
        $stmt = $this->conexao->prepare('SELECT id FROM cestas WHERE usuario_id = :usuario_id LIMIT 1');
        $stmt->execute([':usuario_id' => $usuarioId]);
        $id = $stmt->fetchColumn();

        if (!$id) {
            $insert = $this->conexao->prepare('INSERT INTO cestas (usuario_id) VALUES (:usuario_id)');
            $insert->execute([':usuario_id' => $usuarioId]);
            $id = (int) $this->conexao->lastInsertId();
        }

        $this->id = (int) $id;
        return $this->id;
    }

    public function adicionarProduto(int $produtoId): bool
    {
        if (!$this->id) {
            return false;
        }

        $stmt = $this->conexao->prepare(
            'INSERT IGNORE INTO cesta_produtos (cesta_id, produto_id)
             VALUES (:cesta_id, :produto_id)'
        );
        return $stmt->execute([':cesta_id' => $this->id, ':produto_id' => $produtoId]);
    }

    public function listarProdutos(): array
    {
        if (!$this->id) {
            return [];
        }

        $stmt = $this->conexao->prepare(
            'SELECT p.id, p.nome, p.preco, p.descricao, p.img
             FROM cesta_produtos cp
             INNER JOIN produtos p ON p.id = cp.produto_id
             WHERE cp.cesta_id = :cesta_id
             ORDER BY p.nome'
        );
        $stmt->execute([':cesta_id' => $this->id]);
        return $stmt->fetchAll();
    }

    public function removerProduto(int $produtoId): bool
    {
        if (!$this->id) {
            return false;
        }
        $stmt = $this->conexao->prepare(
            'DELETE FROM cesta_produtos WHERE cesta_id = :cesta_id AND produto_id = :produto_id'
        );
        return $stmt->execute([':cesta_id' => $this->id, ':produto_id' => $produtoId]);
    }

    public function calcularTotal(array $produtos): float
    {
        return array_reduce($produtos, fn(float $total, array $produto): float => $total + (float) $produto['preco'], 0.0);
    }
}
