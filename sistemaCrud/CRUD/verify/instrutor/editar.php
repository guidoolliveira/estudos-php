<?php
require "../../dbconfig/conexao.php";

if (isset($_POST["id"]) && isset($_POST["nome"]) && isset($_POST["idespecializacao"]) && isset($_POST["celular"])) {
  $id = $_POST["id"];
  $nome = $_POST["nome"];
  $idespecializacao = $_POST["idespecializacao"];
  $celular = $_POST["celular"];

  $sql = "UPDATE instrutores SET nome = :nome, idespecializacao = :idespecializacao, celular = :celular WHERE idinstrutores = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindValue(":nome", $nome);
  $stmt->bindValue(":idespecializacao", $idespecializacao);
  $stmt->bindValue(":celular", $celular);
  $stmt->bindValue(":id", $id);
  $stmt->execute();

  header("Location: ../../instrutores.php?nome-instrutor=$nome&edit=ok");
} else {
  header("Location: ../../instrutores.php?erro=1");
  
}
