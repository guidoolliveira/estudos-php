<?php
require "../../dbconfig/conexao.php";

if (isset($_POST["nivelAcesso"]) && isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["nome"]) && !empty($_POST["nome"]) && isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["usuario"]) && !empty($_POST["usuario"]) && isset($_POST["senha"]) && !empty($_POST["senha"])) {
  $id = $_POST["id"];
  $nome = $_POST["nome"];
  $email = $_POST["email"];
  $usuario = $_POST["usuario"];
  $senha = $_POST["senha"];
  $nivelAcesso = $_POST["nivelAcesso"];
  if ($email && $usuario && $senha) {
    $sql = "SELECT * FROM login WHERE email = :email AND id != :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      header("Location: funcionarios.php?alerta=emailExiste&email=$email");
    } else {
      $sql = "SELECT * FROM login WHERE usuario = :usuario AND id != :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(":id", $id);
      $stmt->bindValue(":usuario", $usuario);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        header("Location: funcionarios.php?alerta=usuarioExiste&usuario=$usuario");
      } else {
        $sql = "UPDATE login SET nome = :nome, email = :email, usuario = :usuario, senha = :senha, nivelAcesso = :nivelAcesso WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":usuario", $usuario);
        $stmt->bindValue(":senha", $senha);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":nivelAcesso", $nivelAcesso);
        $stmt->execute();

        header("Location: funcionarios.php?alerta=editadoFuncionario&nome-funcionario=$nome");
      }
    }
  }
} else {
  header("Location: funcionarios.php?alerta=preencher-campos");
}
