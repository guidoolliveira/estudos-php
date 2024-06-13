<?php
if(isset($_POST["id"]) && $nome = $_POST["nome"]) {
  require "../../dbconfig/conexao.php";
  $nome = $_POST["nome"];
  $id = $_POST["id"];
  $sql = "UPDATE categoria SET nome = :nome WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindValue(":nome", $nome);
  $stmt->bindValue(":id", $id);
  $stmt->execute();
  header("Location: ../produto/produtos.php?nome-especializacao=$nome&editado");
} else {
  header("Location: ../produto/produtos.php?erro=1");
  
}
