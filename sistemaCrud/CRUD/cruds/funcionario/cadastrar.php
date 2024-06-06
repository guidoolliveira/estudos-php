<?php
if (isset($_POST["submit"]) && isset($_POST["nome"]) && !empty($_POST["nome"]) && isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["usuario"]) && !empty($_POST["usuario"]) && isset($_POST["senha"]) && !empty($_POST["senha"])) {
    require ("../../dbconfig/conexao.php");
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    if ($email && $usuario && $senha) {
        $sql = "SELECT * FROM login WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            header("Location: ../../funcionarios.php?erro=1");
        } else {
            $sql = "SELECT * FROM login WHERE usuario = :usuario";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usuario", $usuario);
            $stmt->execute();
            // erro 1 = email-ja-cadastrado
            // erro 2 = usuario-ja-cadastrado
            // erro 3 = preencha-todos-os-campos
            if ($stmt->rowCount() > 0) {
                header("Location: ../../funcionarios.php?erro=2");
            } else {
                $sql = "INSERT INTO login (nome,email,usuario,senha) VALUES (:nome, :email, :usuario, :senha)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":nome", $nome);
                $stmt->bindValue(":email", $email);
                $stmt->bindValue(":usuario", $usuario);
                $stmt->bindValue(":senha", $senha);
                $stmt->execute();
                header("Location: ../../funcionarios.php?resposta=ok");
            }
        }
    }
} else {
    header("Location: ../../funcionarios.php?erro=3");
}
