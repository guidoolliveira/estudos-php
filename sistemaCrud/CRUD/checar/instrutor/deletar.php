<?php
if(isset($_POST["id"])) {
    require "../../dbconfig/conexao.php";
    $nome = $_POST["nome"];
    $idinstrutores = $_POST["id"];
    
    $sql = "DELETE FROM instrutores WHERE idinstrutores = :idinstrutores";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":idinstrutores", $idinstrutores);
    $stmt->execute();
    header("Location: ../../instrutores.php?nome-instrutor=$nome&delete=ok");

}
