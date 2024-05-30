<?php
require "../../dbconfig/conexao.php";

if (isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["nome"]) && !empty($_POST["nome"]) && isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["usuario"]) && !empty($_POST["usuario"]) && isset($_POST["senha"]) && !empty($_POST["senha"])) {
  $id = $_POST["id"];
  $nome = $_POST["nome"];
  $email = $_POST["email"];
  $usuario = $_POST["usuario"];
  $senha = $_POST["senha"];

  $sql = "UPDATE login SET nome = :nome, email = :email, usuario = :usuario, senha = :senha WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindValue(":nome", $nome);
  $stmt->bindValue(":email", $email);
  $stmt->bindValue(":usuario", $usuario);
  $stmt->bindValue(":senha", $senha);
  $stmt->bindValue(":id", $id);
  $stmt->execute();

  header("Location: ../../funcionarios.php?nome-funcionario=$nome&edit=ok");
} else {
  header("Location: ../../funcionarios.php?erro=1");
  
}
