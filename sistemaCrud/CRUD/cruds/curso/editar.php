<?php
if (isset($_POST["id"]) && isset($_POST["nome"]) && !empty($_POST["nome"]) && isset($_POST["comeco"]) && !empty($_POST["comeco"]) && isset($_POST["fim"]) && !empty($_POST["fim"]) && isset($_POST["descricao"]) && !empty($_POST["descricao"]) && isset($_POST["dias"]) && !empty($_POST["dias"]) && isset($_POST["instrutor"]) && !empty($_POST["instrutor"])) {
  require ("../../dbconfig/conexao.php");
  $id = $_POST["id"];
  $nome = $_POST["nome"];
  $comeco = $_POST["comeco"];
  $fim = $_POST["fim"];
  $descricao = $_POST["descricao"];
  $instrutor = $_POST["instrutor"];
  $dias = $_POST["dias"];

  $sql = "UPDATE cursos SET nome = :nome, horaInicio = :horaInicio, horaFinal = :horaFinal, descricao = :descricao, dias = :dias, idinstrutores = :idinstrutores WHERE id = :id;";
  $stmt= $conn->prepare($sql);
  $stmt->bindValue("id", $id);
  $stmt->bindValue("nome", $nome);
  $stmt->bindValue("horaInicio", $comeco);
  $stmt->bindValue("horaFinal", $fim);
  $stmt->bindValue("descricao", $descricao);
  $stmt->bindValue("dias", $dias);
  $stmt->bindValue("idinstrutores", $instrutor);
  $stmt->execute();
  header("Location: cursos.php?alerta=editadoCurso&nome-curso=$nome");
}else{
  // Campos nao preenchidos
  header("Location: instrutores.php?alerta=preencher-campos");
}
