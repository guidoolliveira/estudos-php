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
    $qntd = $stmt->rowCount();
    if ($qntd == 1) {
        $dado = $stmt->fetch();
        $_SESSION["idusers"] = $dado["id"];
        $_SESSION["nome"] = $dado["usuario"];
        $_SESSION["acesso"] = $dado["nivelAcesso"];
        header("Location: ../../index.php");
    }
// erro 1 = dados-invalidos
// erro 2 = preencha-todos-os-campos
    else {
        header("Location: login.php?erro=1");
    }
} else {
    header("Location: login.php?erro=2");
}
