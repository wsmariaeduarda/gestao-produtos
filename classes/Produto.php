<?php

class Produto {
    private $id;
    private $nome;
    private $fornecedor_id;
    private $preco;
    private $descricao;
    private $img;

    public function __construct($id, $nome, $fornecedor_id, $preco, $descricao, $img) {
        $this->id = $id;
        $this->nome = $nome;
        $this->fornecedor_id = $fornecedor_id;
        $this->preco = $preco;
        $this->descricao = $descricao;
        $this->img = $img;
    }
}