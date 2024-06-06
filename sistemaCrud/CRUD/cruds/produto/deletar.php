<?php
if(isset($_POST["id"])) {
    require "../../dbconfig/conexao.php";
    $nome = $_POST["nome"];
    $id = $_POST["id"];
    
    $sql = "DELETE FROM produtos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    header("Location: produtos.php?nome-produto=$nome&deletar=ok");

}else{
    header("Location: produtos.php?nome-produto=$nome&deletar=erro");
}
