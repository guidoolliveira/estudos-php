<<?php
if (isset($_POST["login"]) && !empty($_POST["login"]) && isset($_POST["senha"]) && !empty($_POST["senha"])) {
    session_start();
    require ("../../dbconfig/conexao.php");
    $login = $_POST["login"];
    $senha = $_POST["senha"];
    $sql = "SELECT * FROM login WHERE (usuario = :login OR email = :login) AND senha = :senha LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue("login", $login);
    $stmt->bindValue("senha", $senha);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $info = $stmt->fetch();
        $_SESSION["idusers"] = $info["id"];
        $_SESSION["nome"] = $info["usuario"];
        $_SESSION["acesso"] = $info["nivelAcesso"];
        header("Location: ../../index.php");
    }
    else {
        header("Location: login.php?alerta=login-ou-senha-incorretos");
    }
} else {
    header("Location: login.php?alerta=preencher-campos");
}
