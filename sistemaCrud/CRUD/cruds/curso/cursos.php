<!-- erro 1 = email-ja-cadastrado
erro 2 = usuario-ja-cadastrado
erro 3 = preencha-todos-os-campos -->
<?php
require "../template/sidebar.php";
$sql = "SELECT c.nome, c.id, c.descricao, c.dias, c.horaInicio, c.horaFinal, i.nome as instrutor FROM cursos as c join instrutores as i ON c.idinstrutores = i.idinstrutores;
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container mt-3">
    <h2 class="mb-0 mt-3 py-0">Cursos</h2>
    <hr class="mt-0">
    <?php
    echo '<button class="btn btn-primary mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#modalCadastrar">Cadastrar</button>';
    ?>
    <?php
    if (count($cursos) > 0) { ?>
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover table-bordered">
                <thead class="">
                    <tr class="text-center">
                        <th>Nome</th>
                        <th>Começo</th>
                        <th>Fim</th>
                        <th>Dias</th>
                        <th>Descrição</th>
                        <th>Instrutor</th>
                        <?php
                        if ($_SESSION["acesso"] == 1) {
                            echo "<th>Ações</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($cursos as $curso) {
                        echo "<tr class='text-center'>";
                        echo "<td>" . $curso["nome"] . "</td>";
                        echo "<td class='text-nowrap' >" . $curso["horaInicio"] . "</td>";
                        echo "<td>" . $curso["horaFinal"] . "</td>";
                        echo "<td >" . $curso["dias"] . "</td>";
                        echo "<td>" . $curso["descricao"] . "</td>";
                        echo "<td>" . $curso["instrutor"] . "</td>";
                        if ($_SESSION["acesso"] == 1) {
                            echo "<td><span>
                            <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditar" . $curso['id'] . "'>Editar</button>
                            <button class='btn btn-danger btn-sm ' data-bs-toggle='modal' data-bs-target='#modalDeletar" . $curso['id'] . "'>Excluir</button>
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

<?php foreach ($cursos as $curso) { ?>
    <!-- Modal deletar -->
    <div class="modal fade" id="modalDeletar<?php echo $curso['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir o cur$curso <?php
                    echo $curso['usuario']
                        ?>? </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span>Está ação é irreversível!</span>
                    <form method='post' action='deletar.php'>
                        <input type='hidden' name='id' value="<?php echo $curso['id']; ?>" />
                        <input type='hidden' name='nome' value="<?php echo $curso['nome']; ?>" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar<?php echo $curso['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar cur$curso</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="editar.php" method="post" data-parsley-validate novalidate>
                        <input type="hidden" name="id" value="<?php echo $curso['id']; ?>">
                        <div class="mb-3 mx-4">
                            <span class="form-label">Nome</span>
                            <input type="text" class="form-control" name="nome" value="<?php echo $curso['nome']; ?>"
                                required>
                        </div>
                        <div class="mb-3 mx-4">
                            <span class="form-label">Email</span>
                            <input type="text" class="form-control" name="email" value="<?php echo $curso['email']; ?>"
                                required>
                        </div>
                        <div class="mb-3 mx-4">
                            <span class="form-label">Usuário</span>
                            <input type="text" class="form-control" name="usuario" value="<?php echo $curso['usuario']; ?>"
                                required>
                        </div>
                        <div class="mb-3 mx-4">
                            <span class="form-label">Senha</span>
                            <input type="text" class="form-control" name="senha" value="<?php echo $curso['senha']; ?>"
                                required>
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
    <?php
}
?>

<!-- Modal Cadastrar -->
<div class="modal fade" id="modalCadastrar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar curso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="cadastrar.php" method="post" data-parsley-validate novalidate>
                    <div class="mb-3 mx-4">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>
                    <div class="mb-3 mx-4">
                        <label for="comeco" class="form-label">Começo</label>
                        <input type="comeco" class="form-control" name="comeco" id="comeco" required>
                    </div>
                    <div class="mb-3 mx-4">
                        <label for="fim" class="form-label">Fim</label>
                            <input type="text" class="form-control" name="fim" id="fim" required>
                    </div>
                    <div class="mb-3 mx-4">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" name="descricao" id="descricao" required>
                        </div>
                        <div class="mb-3 mx-4">
                            <label for="dias" class="form-label">Dias</label>
                            <select name="dias" id="dias" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="Seg/Qua">Seg/Qua</option>
                                <option value="Ter/Qui">Ter/Qui</option>
                            </select>
                        </div>
                        <div class="mb-3 mx-4">
                            <span class="form-label">Instrutor</span>
                            <select class="form-select" name="instrutor" required>
                                <option value="">Selecione</option>
                                <?php $sql = "SELECT * FROM instrutores;";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $instrutores = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($instrutores as $instrutor) {
                                    echo "<option value=" . $instrutor["idinstrutores "] . ">" . $instrutor["nome"] . "</option>";
                                }
                                ?>
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