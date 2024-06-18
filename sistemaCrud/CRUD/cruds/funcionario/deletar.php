<?php
if(isset($_POST["id"])) {
    require "../../dbconfig/conexao.php";
    $nome = $_POST["nome"];
    $id = $_POST["id"];
    
    $sql = "DELETE FROM login WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    header("Location: funcionarios.php?alerta=deletadoFuncionario&nome-funcionario=$nome");
} else {
  header("Location: funcionarios.php?alerta=preencher-campos");
}
