<!-- erro 1 = email-ja-cadastrado
erro 2 = usuario-ja-cadastrado
erro 3 = preencha-todos-os-campos -->
<?php
session_start();
require "dbconfig/conexao.php";
if (!isset($_SESSION["idusers"])) {
    header("Location: login.php");
}
require "template/header.php";
require "template/sidebar.php";
$sql = "SELECT * FROM login;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$login = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container mt-3">
    <h2 class="mb-0 mt-3 py-0">Funcionários</h2>
    <hr class="mt-0">
    <?php
    if (isset($_GET["erro"]) && $_GET["erro"] == "1") {
        echo "<div style='top: 3rem' class=''>
          <div class='alert alert-danger alert-dismissible fade show fw-semibold text-center' role='alert'>
              Preencha todos os campos!
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>
      </div>";
    }
    if (isset($_GET["deletar"]) && $_GET["deletar"] == "ok") {
        echo '<div style="top: 3rem" class="">
        <div class="alert alert-warning alert-dismissible fade show fw-semibold text-center" role="alert">
            O funcionário ' . $_GET["nome-funcionario"] . ' foi deletado com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert"
            "" aria-label="Close"></button>
        </div>
    </div>';
    }
    if (isset($_GET["edit"]) && $_GET["edit"] == "ok") {
        echo '<div style="top: 3rem" class="">
        <div class="alert alert-success alert-dismissible fade show fw-semibold text-center" role="alert">
            O funcionário ' . $_GET["nome-funcionario"] . ' foi editado com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert"
            "" aria-label="Close"></button>
        </div>
    </div>';
    }


    ?>
    <button class="btn btn-primary mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#modalCadastrar">Cadastrar</button>

    <?php
    if (count($login) > 0) { ?>
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead class="">
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($login as $funcionario) {
                        echo "<tr>";
                        echo "<td>" . $funcionario["id"] . "</td>";
                        echo "<td>" . $funcionario["nome"] . "</td>";
                        echo "<td>" . $funcionario["email"] . "</td>";
                        echo "<td>" . $funcionario["usuario"] . "</td>";
                        if ($_SESSION["acesso"] == 1) {
                            echo "<td><span>
              <button class='btn btn-danger btn-sm ' data-bs-toggle='modal' data-bs-target='#modalDeletar" . $funcionario['id'] . "'>Excluir</button>
              <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditar" . $funcionario['id'] . "'>Editar</button>
              </span>
          </td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    } else {
        echo '<h3 class="text-warning text-center">Ainda não há intrutores cadastrados!</h3>';

    } ?>
</div>
</div>

<?php foreach ($login as $funcionario) { ?>
    <!-- Modal deletar -->
    <div class="modal fade" id="modalDeletar<?php echo $funcionario['id']; ?>" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir o funcionario <?php
                    echo $funcionario['nome']
                        ?>? </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span>Está ação é irreversível!</span>
                    <form method='post' action='checar/funcionario/deletar.php'>
                        <input type='hidden' name='id' value="<?php echo $funcionario['id']; ?>" />
                        <input type='hidden' name='nome' value="<?php echo $funcionario['nome']; ?>" />

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Editar funcionario -->
    <div class="modal fade" id="modalEditar<?php echo $funcionario['id']; ?>" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Funcionario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="checar/funcionario/editar.php" method="post" data-parsley-validate novalidate>
                        <input type="hidden" name="id" value="<?php echo $funcionario['id']; ?>">
                        <div class="mb-3 mx-4">
                            <span class="form-label">Nome</span>
                            <input type="text" class="form-control" name="nome" value="<?php echo $funcionario['nome']; ?>"
                                required>
                        </div>
                        <div class="mb-3 mx-4">
                            <span class="form-label">Email</span>
                            <input type="text" class="form-control" name="email"
                                value="<?php echo $funcionario['email']; ?>" required>
                        </div>
                        <div class="mb-3 mx-4">
                            <span class="form-label">Usuário</span>
                            <input type="text" class="form-control" name="usuario"
                                value="<?php echo $funcionario['usuario']; ?>" required>
                        </div>
                        <div class="mb-3 mx-4">
                            <span class="form-label">Senha</span>
                            <input type="text" class="form-control " name="senha"
                                value="<?php echo $funcionario['senha']; ?>" required>
                            <div class="invalid-feedback">
                                Preencha este campo!
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="submit" class="btn btn-primary">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Cadastrar -->
    <div class="modal fade" id="modalCadastrar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar Funcionario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="checar/funcionario/cadastrar.php" method="post" data-parsley-validate novalidate>
                        <input type="hidden" name="id">
                        <div class="mb-3 mx-4">
                            <span class="form-label">Nome</span>
                            <input type="text" class="form-control" name="nome" value="" required>
                        </div>
                        <div class="mb-3 mx-4">
                            <span class="form-label">Email</span>
                            <input type="email" class="form-control" name="email" value="" required>
                        </div>
                        <div class="mb-3 mx-4">
                            <span class="form-label">Usuário</span>
                            <input type="text" class="form-control" name="usuario" value="" required>
                        </div>
                        <div class="mb-1 mx-4">
                            <span class="form-label">Senha</span>
                            <input type="password" class="form-control" name="senha" value="" id="senha" required>
                        </div>
                        <div class="form-check mx-4">
                            <input class="form-check-input me-2" type="checkbox" onclick="mostrarSenha()" value="" id="">
                            <label class="form-check-label" for="">
                                Mostrar Senha
                            </label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="submit" class="btn btn-primary">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<?php
require "template/footer.php";
require "checar/validarInput.php";
?>