<?php
require_once '../connect.php';

class Produto{
    public $id;
    public $nome;
    public $descricao;
    public $valor;

    public function setProduto($conn, $nome, $descricao, $valor){
        $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, valor) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $descricao, $valor);
        $stmt->execute();
    }

    public function getProduto($conn){
        $stmt = $conn->prepare("SELECT * FROM produtos");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all();
        return $result;
    }

}

$produto = new Produto;

$result = $produto->getProduto($conn);
print_r($result);