<?php
  if (
    isset($_POST["id"]) && !empty(trim($_POST["id"])) &&
    isset($_POST["nome"]) && !empty(trim($_POST["nome"])) &&
    isset($_POST["quantidade"]) && !empty(trim($_POST["quantidade"])) &&
    isset($_POST["preco"]) && !empty(trim($_POST["preco"])) &&
    isset($_POST["fornecedor"]) && !empty(trim($_POST["fornecedor"])) &&
    isset($_POST["idcategoria"]) && !empty(trim($_POST["idcategoria"]))
) {
    require("../../dbconfig/conexao.php");
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $quantidade = $_POST["quantidade"];
    $preco = $_POST["preco"];
    $fornecedor = $_POST["fornecedor"];
    $idcategoria = $_POST["idcategoria"];

  $sql = "UPDATE produtos SET nome = :nome, quantidade = :quantidade, preco = :preco, fornecedor = :fornecedor,idcategoria = :idcategoria  WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindValue(":nome", $nome);
  $stmt->bindValue(":quantidade", $quantidade);
  $stmt->bindValue(":preco", $preco);
  $stmt->bindValue(":fornecedor", $fornecedor);
  $stmt->bindValue(":idcategoria", $idcategoria);
  $stmt->bindValue(":id", $id);
  $stmt->execute();

  header("Location: produtos.php?nome-produto=$nome&edit=ok");
} else {
  header("Location: produtos.php?erro=1");
}
