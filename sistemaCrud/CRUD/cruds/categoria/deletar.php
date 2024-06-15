<?php
if(isset($_POST["id"]) && $nome = $_POST["nome"]) {
    require "../../dbconfig/conexao.php";
    $nome = $_POST["nome"];
    $id = $_POST["id"];
    $sql = "DELETE FROM categoria WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    header("Location: ../produto/produtos.php?alerta=deletadoCategori&nome-categoria=$nome");

}
