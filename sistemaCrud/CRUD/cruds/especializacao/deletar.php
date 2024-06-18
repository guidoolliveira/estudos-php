<?php
if(isset($_POST["id"]) && $nome = $_POST["nome"]) {
    require "../../dbconfig/conexao.php";
    $nome = $_POST["nome"];
    $id = $_POST["id"];
    $sql = "DELETE FROM especializacao WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    header("Location: ../instrutor/instrutores.php?nome-especializacao=$nome&deletar=ok");
}else {
    header("Location: ../instrutor/instrutores.php?alerta=preencher-campos");
  }
