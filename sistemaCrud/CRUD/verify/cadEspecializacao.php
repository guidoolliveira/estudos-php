<?php
if (isset($_POST["submit"]) && 
isset($_POST["nomeEspecializacao"]) && !empty($_POST["nomeEspecializacao"])) {
    require ("../dbconfig/conexao.php");
    $nomeEspecializacao = $_POST["nomeEspecializacao"];
    $sql = "INSERT INTO especializacao(nomeEspecializacao) VALUES(:nomeEspecializacao);";
    $stmt= $conn->prepare($sql);
    $stmt->bindValue("nomeEspecializacao", $nomeEspecializacao);
    $stmt->execute();
    header("Location: ../instrutores.php?nomeEspecializacao=$nomeEspecializacao");
}else{
    // Campos nao preenchidos
    header("Location: ../instrutores.php?erro=1");
}
