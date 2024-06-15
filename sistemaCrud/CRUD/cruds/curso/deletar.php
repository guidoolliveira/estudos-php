<?php
if(isset($_POST["id"])) {
    require "../../dbconfig/conexao.php";
    $nome = $_POST["nome"];
    $id = $_POST["id"];
    
    $sql = "DELETE FROM cursos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    header("Location: cursos.php?alerta=deletadoCurso&nome-curso=$nome");
}
