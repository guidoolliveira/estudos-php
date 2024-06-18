<?php
require "../template/sidebar.php";
$sql = "SELECT * FROM login;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$login = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container mt-3">
    <h2 class="mb-0 mt-3 py-0"><i class="fa-solid fa-users me-3 ms-2 fs-2"></i>Funcionários</h2>
    <hr class="mt-0">
    <?php

    if (isset($_GET["alerta"])) {
        $corAlerta = "";
        $mensagemAlerta = "";
        if ($_GET["alerta"] == "preencher-campos") {
            $corAlerta = "danger";
            $mensagemAlerta = "Preencha todos os campos!";
        }
        if ($_GET["alerta"] == "cadastroFuncionario") {
            $corAlerta = "success";
            $mensagemAlerta = "O funcionario " . $_GET['nome-funcionario'] . " foi cadatrado com sucesso!";
        }
        if ($_GET["alerta"] == "editadoFuncionario") {
            $corAlerta = "success";
            $mensagemAlerta = "O funcionario " . $_GET['nome-funcionario'] . " foi editado com sucesso!";
        }
        if ($_GET["alerta"] == "deletadoFuncionario") {
            $corAlerta = "success";
            $mensagemAlerta = "O funcionario " . $_GET['nome-funcionario'] . " foi deletado com sucesso!";
        }
        if ($_GET["alerta"] == "emailExiste") {
            $corAlerta = "danger";
            $mensagemAlerta = "O email " . $_GET['email'] . " ja existe!";
        }
        if ($_GET["alerta"] == "usuarioExiste") {
            $corAlerta = "danger";
            $mensagemAlerta = "O usuario " . $_GET['usuario'] . " ja existe!";
        }
        echo "
          <div class='alert alert-$corAlerta alert-dismissible fade show fw-semibold text-center' role='alert'>
            <span>$mensagemAlerta</span>
            <a href='funcionarios.php' class='btn-close'></a>
          </div>";
    }
    echo '<button class="btn btn-primary mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#modalCadastrar">Cadastrar</button>';
    ?>
    <?php
    if (count($login) > 0) { ?>
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover table-bordered">
                <thead class="">
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Nivel de Acesso</th>
                        <?php
                        if ($_SESSION["acesso"] == 1) {
                            echo "<th>Ações</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($login as $funcionario) {
                        if ($funcionario["id"] != $_SESSION["idusers"]) {
                            echo "<tr class='text-center'>";
                            echo "<td>" . $funcionario["id"] . "</td>";
                            echo "<td class='text-nowrap' >" . $funcionario["nome"] . "</td>";
                            echo "<td>" . $funcionario["email"] . "</td>";
                            echo "<td>" . $funcionario["usuario"] . "</td>";
                            if($funcionario["nivelAcesso"] == "1"){
                                $acesso="Administrador";
                            }else{
                                $acesso="Funcionário";
                            }
                            echo "<td>" . $acesso . "</td>";
                            if ($_SESSION["acesso"] == 1) {
                                echo "<td><span>
                            <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditar" . $funcionario['id'] . "'>Editar</button>
                            <button class='btn btn-danger btn-sm ' data-bs-toggle='modal' data-bs-target='#modalDeletar" . $funcionario['id'] . "'>Excluir</button>
              </span>
          </td>";
                            }
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    } else {
        echo '<h3 class="text-warning text-center">Ainda não há funcionários cadastrados!</h3>';
    } ?>
</div>
</div>

<?php foreach ($login as $funcionario) { ?>
    <!-- Modal deletar -->
    <div class="modal fade" id="modalDeletar<?php echo $funcionario['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir o funcionario <?php echo $funcionario['usuario'] ?>? </h1>
                    <a href='funcionarios.php' class='btn-close'></a>
                </div>
                <div class="modal-body">
                    <span>Está ação é irreversível!</span>
                    <form method='post' action='deletar.php'>
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
    <div class="modal fade" id="modalEditar<?php echo $funcionario['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Funcionario</h1>
                    <a href='funcionarios.php' class='btn-close'></a>
                </div>
                <div class="modal-body">
                    <form action="editar.php" method="post" data-parsley-validate novalidate>
                        <input type="hidden" name="id" value="<?php echo $funcionario['id']; ?>">
                        <div class="mb-3 mx-4">
                            <label for="nome" class="form-label">Nome<span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" name="nome" id="nome" value="<?php echo $funcionario['nome']; ?>" required>
                        </div>
                        <div class="mb-3 mx-4">
                            <label for="email" class="form-label">Email<span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" name="email" id="email" value="<?php echo $funcionario['email']; ?>" required>
                        </div>
                        <div class="mb-3 mx-4">
                            <label for="usuario" class="form-label">Usuário<span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $funcionario['usuario']; ?>" required>
                        </div>
                        <div class="mb-3 mx-4">
                            <label for="senha2" class="form-label">Senha<span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" id="senha2" name="senha" value="<?php echo $funcionario['senha']; ?>" required>
                        </div>
                        <div class="mb-1 mx-4">
                        <label class="form-label">Nivel de acesso<span class="text-danger fw-bold">*</span></label>
                        <select class="form-select" name="nivelAcesso" id="nivelAcesso" required>
                            <option value="1" <?php if($funcionario["nivelAcesso"] == "1"){echo "selected";}?>>Adminstrador</option>
                            <option value="0" <?php if($funcionario["nivelAcesso"] == "0"){echo "selected";}?>>Funcionário</option>
                        </select>
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

<!-- Modal Cadastrar -->
<div class="modal fade" id="modalCadastrar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar Funcionario</h1>
                <a href='funcionarios.php' class='btn-close'></a>
            </div>
            <div class="modal-body">
                <form action="cadastrar.php" method="post" data-parsley-validate novalidate>
                    <input type="hidden" name="id">
                    <div class="mb-3 mx-4">
                        <label class="form-label">Nome<span class="text-danger fw-bold">*</span></label>
                        <input type="text" class="form-control" name="nome" value="" required>
                    </div>
                    <div class="mb-3 mx-4">
                        <label class="form-label">Email<span class="text-danger fw-bold">*</span></label>
                        <input type="email" class="form-control" name="email" value="" required>
                    </div>
                    <div class="mb-3 mx-4">
                        <label class="form-label">Usuário<span class="text-danger fw-bold">*</span></label>
                        <input type="text" class="form-control" name="usuario" value="" required>
                    </div>
                    <div class="mb-1 mx-4">
                        <label class="form-label">Senha<span class="text-danger fw-bold">*</span></label>
                        <input type="password" class="form-control" name="senha" value="" id="senha" required>
                    </div>
                    <div class="form-check mx-4 mb-3">
                        <input class="form-check-input me-2" onclick="mostrarSenha()" type="checkbox" value="" id="mostrar">
                        <label class="form-check-label" for="mostrar">
                            Mostrar Senha
                        </label>
                    </div>
                    <div class="mb-1 mx-4">
                        <label class="form-label">Nivel de acesso<span class="text-danger fw-bold">*</span></label>
                        <select class="form-select" name="nivelAcesso" id="nivelAcesso" required>
                            <option value="">Selecione</option>
                            <option value="1">Adminstrador</option>
                            <option value="0">Funcionário</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="submit" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require "../template/footer.php";
require "../validarInput.php";
?>