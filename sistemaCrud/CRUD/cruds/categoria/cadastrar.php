<?php
if (isset($_POST["nomeCategoria"]) && !empty($_POST["nomeCategoria"])) {
    require ("../dbconfig/conexao.php");
    $nomeCategoria = $_POST["nomeCategoria"];
    $sql = "INSERT INTO categoria (nome) VALUES(:nomeCategoria);";
    $stmt= $conn->prepare($sql);
    $stmt->bindValue("nomeCategoria", $nomeCategoria);
    $stmt->execute();
    header("Location: ../produto/produtos.php?nomeCategoria=$nomeCategoria");
}else{
    // Campos nao preenchidos
    header("Location:  ../produto/produtos.php?erro=1");
}