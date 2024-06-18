<?php
require "../template/header.php"; 

if (isset($_GET["alerta"])) {
    $corAlerta = "";
    $mensagemAlerta = "";
    if ($_GET["alerta"] == "preencher-campos") {
        $corAlerta = "danger";
        $mensagemAlerta = "Preencha todos os campos!";
    }
    echo "
  <div class='alert alert-$corAlerta alert-dismissible fade show fw-semibold text-center' role='alert'>
    <span>$mensagemAlerta</span>
    <a href='login.php' class='btn-close'></a>
  </div>";
}
?>
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5 text-center">
                <img src="../../assets/logo.png" class="img-fluid" alt="">
            </div>

            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <h2 class="text-center">Painel de Acesso</h2>
                <hr>
                <div class="text-center mb-2">
                <span class="corErro">
                            <?php
                            if (isset($_GET["alerta"]) && $_GET["alerta"] == "login-ou-senha-incorretos") {
                                echo "<i class='fa-solid fa-circle-exclamation'></i> Login ou Senha incorretos.";
                            }
                            ?>
                        </span>
                    </div>
                <form action="logar.php" method="post" data-parsley-validate novalidate>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="login">Email ou Usuário<span class="text-danger fw-bold">*</span></label>
                        <input type="text" id="login" name="login" class="form-control form-control-lg"
                            placeholder="Digite seu e-mail ou usuário" required>
                        
                    </div>
                    <div class="form-outline mb-3">
                        <label class="form-label" for="senha">Senha<span class="text-danger fw-bold">*</span></label>
                        <input type="password" id="senha" name="senha" class="form-control form-control-lg"
                            placeholder="Digite a senha" required>

                    </div>

                    <div class="form-check mb-0">
                        <input class="form-check-input me-2" type="checkbox" onclick="mostrarSenha()" value="" id="ver">
                        <label class="form-check-label" for="ver">
                            Mostrar Senha
                        </label>
                    </div>
                    <div class="text-center text-lg-start mt-4 pt-2 mb-5">
                        <button type="submit" class="btn btn-primary w-100 mb-2 fw-semibold" name="submit">
                            Entrar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</section>
<?php
require "../template/footer.php";
?>