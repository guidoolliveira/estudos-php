<?php
if (isset($_POST["submit"]) && 
isset($_POST["nome"]) && !empty($_POST["nome"]) && 
isset($_POST["idespecializacao"]) && !empty($_POST["idespecializacao"]) && 
isset($_POST["celular"]) && !empty($_POST["celular"])) {
    require ("../../dbconfig/conexao.php");
    $nome = $_POST["nome"];
    $idespecializacao = $_POST["idespecializacao"];
    $celular = $_POST["celular"];
    $sql = "INSERT INTO instrutores(nome, idespecializacao, celular) VALUES(:nome, :idespecializacao, :celular);";
    $stmt= $conn->prepare($sql);
    $stmt->bindValue("nome", $nome);
    $stmt->bindValue("idespecializacao", $idespecializacao);
    $stmt->bindValue("celular", $celular);
    $stmt->execute();
    header("Location: ../../instrutores.php?nome-instrutor=$nome&success=ok");
}else{
    // Campos nao preenchidos
    header("Location: ../../instrutores.php?erro=1");
}
