<?php
if(isset($_POST["id"])) {
    require "../../dbconfig/conexao.php";
    $nome = $_POST["nome"];
    $id = $_POST["id"];
    
    $sql = "DELETE FROM login WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    header("Location: ../../funcionarios.php?nome-funcionario=$nome&deletar=ok");

}else{
    header("Location: ../../funcionarios.php?nome-funcionario=$nome&deletar=erro");
}
