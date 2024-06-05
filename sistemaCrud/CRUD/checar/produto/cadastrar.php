<?php
if (isset($_POST["nome"]) && !empty($_POST["nome"]) && isset($_POST["quantidade"]) && !empty($_POST["quantidade"]) && isset($_POST["preco"]) && !empty($_POST["preco"]) && isset($_POST["fornecedor"]) && !empty($_POST["fornecedor"]) && isset($_POST["idcategoria"]) && !empty($_POST["idcategoria"])) {
    require ("../../dbconfig/conexao.php");
    $nome = $_POST["nome"];
    $quantidade = $_POST["quantidade"];
    $preco = $_POST["preco"];
    $fornecedor = $_POST["fornecedor"];
    $idcategoria = $_POST["idcategoria"];
    $sql = "INSERT INTO produtos(nome, quantidade, preco, fornecedor, idcategoria) VALUES(:nome, :quantidade, :preco, :fornecedor, :idcategoria);";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue("nome", $nome);
    $stmt->bindValue("quantidade", $quantidade);
    $stmt->bindValue("preco", $preco);
    $stmt->bindValue("fornecedor", $fornecedor);
    $stmt->bindValue("idcategoria", $idcategoria);
    $stmt->execute();
    header("Location: ../../produtos.php");
} else {
    // Campos nao preenchidos
    header("Location: ../../instrutores.php?erro=1");
}