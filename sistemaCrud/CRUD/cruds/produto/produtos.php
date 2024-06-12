<!-- erro 1 = email-ja-cadastrado
erro 2 = usuario-ja-cadastrado
erro 3 = preencha-todos-os-campos -->
<?php
require "../template/sidebar.php";
$sql = "SELECT * FROM produtos;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container mt-3">
    <h2 class="mb-0 mt-3"><i class="fa-solid fa-cart-shopping me-3 ms-2 fs-2"></i>Produtos: <?php
    $sql = "SELECT * FROM produtos;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->rowCount();
    echo $resultado;
    ?></h2>
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
            O produto ' . $_GET["nome-produto"] . ' foi deletado com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert"
            "" aria-label="Close"></button>
        </div>
    </div>';
    }
    if (isset($_GET["edit"]) && $_GET["edit"] == "ok") {
        echo '<div style="top: 3rem" class="">
        <div class="alert alert-success alert-dismissible fade show fw-semibold text-center" role="alert">
            O produto ' . $_GET["nome-produto"] . ' foi editado com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert"
            "" aria-label="Close"></button>
        </div>
    </div>';
    }
    if ($_SESSION["acesso"] == 1) {
        echo '<button class="btn btn-primary mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#modalCadastrarProduto">Cadastrar</button>
    <button type="button" class="btn btn-primary dropdown-toggle mt-2 mb-3" data-bs-toggle="dropdown" aria-expanded="false"> Categorias
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalCadCategoria" href="#">Cadastrar</a></li>
    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalVisualizarCatego" href="#">Visualizar</a></li>
  </ul>';
    }
    ?>
    <?php
    if (count($produtos) > 0) { ?>
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead class="">
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Fornecedor</th>
                        <th>Categoria</th>
                        <?php
                        if ($_SESSION["acesso"] == 1) {
                            echo "<th class='text-center'>Ações</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($produtos as $produto) {
                        $preco = number_format($produto["preco"], 2, ',', '.');
                        echo "<tr>";
                        echo "<td>" . $produto["id"] . "</td>";
                        echo "<td>" . $produto["nome"] . "</td>";
                        echo "<td>R$ " . $preco . "</td>";
                        echo "<td>" . $produto["quantidade"] . "</td>";
                        echo "<td>" . $produto["fornecedor"] . "</td>";
                        $idcategoria = $produto["idcategoria"];
                        $sql = "SELECT nome FROM categoria WHERE id = :idcategoria ";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue("idcategoria", $idcategoria);
                        $stmt->execute();
                        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($categorias as $categoria) {
                            echo "<td class='text-nowrap'>" . $categoria["nome"] . "</td>";
                        }
                        if ($_SESSION["acesso"] == 1) {
                            echo "<td class='text-center'>
                                <span>
                                <button class='btn btn-primary btn-sm' data-bs-toggle='modal'                     data-bs-target='#modalEditar" . $produto['id'] . "'>Editar</button>
                                <button class='btn btn-danger btn-sm ' data-bs-toggle='modal' data-bs-target='#modalDeletar" . $produto['id'] . "'>Excluir</button>
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
<?php foreach ($produtos as $produto) { ?>
    <!-- Modal deletar -->
    <div class="modal fade" id="modalDeletar<?php echo $produto['id']; ?>" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir o produto <?php
                    echo $produto['nome'] ?>?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span>Está ação é irreversível!</span>
                    <form method='post' action='deletar.php'>
                        <input type='hidden' name='id' value="<?php echo $produto['id']; ?>" />
                        <input type='hidden' name='nome' value="<?php echo $produto['nome']; ?>" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Editar produto -->
    <div class="modal fade" id="modalEditar<?php echo $produto['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Produto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="editar.php" method="post" data-parsley-validate novalidate>
                        <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
                        <div class="mb-3 mx-4">
                            <span class="form-label">Nome</span>
                            <input type="text" class="form-control" name="nome" value="<?php echo $produto['nome']; ?>"
                                required>
                        </div>
                        <div class="mx-4">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <span class="form-label">Quantidade</span>
                                    <input type="number" class="form-control" name="quantidade"
                                        value="<?php echo $produto['quantidade']; ?>" required>
                                </div>
                                <div class="col-sm-6">
                                    <span class="form-label">Preço</span>
                                    <input type="number" step="0.01" class="form-control" name="preco"
                                        value="<?php echo $produto['preco']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mx-4">
                            <span class="form-label">Fornecedor</span>
                            <input type="text" class="form-control" name="fornecedor"
                                value="<?php echo $produto['fornecedor']; ?>" id="" required>
                        </div>
                        <div class="mb-3 mx-4">
                            <span class="form-label">Categoria</span>
                            <select class="form-select" name="idcategoria" required>
                                <?php
                                $sql = "SELECT * FROM categoria;";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($categorias as $categoria) {
                                    if ($categoria["id"] == $produto["idcategoria"]) {
                                        echo "<option value='" . $categoria["id"] . "' selected>" . $categoria["nome"] . "</option>";
                                    } else {
                                        echo "<option value='" . $categoria["id"] . "'>" . $categoria["nome"] . "</option>";
                                    }
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
}
?>
<!-- Modal Cadastrar Produto -->
<div class="modal fade" id="modalCadastrarProduto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar Produto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="cadastrar.php" method="post" data-parsley-validate novalidate>
                    <input type="hidden" name="id">
                    <div class="mb-3 mx-4">
                        <span class="form-label">Nome</span>
                        <input type="text" class="form-control" name="nome" value="" required>
                    </div>
                    <div class="mx-4">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <span class="form-label">Quantidade</span>
                                <input type="number" class="form-control" name="quantidade" value="" required>
                            </div>
                            <div class="col-sm-6">
                                <span class="form-label">Preço</span>
                                <input type="number" step="0.01" class="form-control" name="preco" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 mx-4">
                        <span class="form-label">Fornecedor</span>
                        <input type="text" class="form-control" name="fornecedor" value="" id="" required>
                    </div>
                    <div class="mb-3 mx-4">
                     
                        <span class="form-label">Categoria</span>
                        <select class="form-select" name="idcategoria" required>
                            <option value="">Selecione</option>
                            <?php $sql = "SELECT * FROM categoria;";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($categorias as $categoria) {
                                echo "<option value=" . $categoria["id"] . ">" . $categoria["nome"] . "</option>";
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
<!-- Modal Cadastrar Categoria -->
<div class="modal fade" id="modalCadCategoria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar Categorias</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../cadEspecializacao.php" method="post" data-parsley-validate novalidate>
                    <div class="mb-3 mx-4">
                        <span class="form-label">Nome</span>
                        <input type="text" class="form-control" name="nomeCategoria" placeholder="Categoria " required>
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

<<<<<<< HEAD
<!-- Modal Visualizar Categorias -->
<div class="modal fade" id="modalVisualizarCatego" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
=======
  <!-- Modal Visualizar Categorias -->
  <div class="modal fade" id="modalVisualizarCatego" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
>>>>>>> 9b70806ee6c7e0be07c07107a3607d3b9eaf7674
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Visualizar Categorias</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-dark table-striped">
                        <thead class="">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <?php
                                if ($_SESSION["acesso"] == 1) {
                                    echo "<th>Ações</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM categoria";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($categorias as $categoria) {
                                echo "<td  class='text-nowrap'>" . $categoria["id"] . "</td>";
                                echo "<td  class='text-nowrap'>" . $categoria["nome"] . "</td>";
                                echo "<td class='text-nowrap' ><span>
                            <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditarCate" . $categoria["id"] . "' data-bs-dismiss='modal'>Editar</button>
                            <button class='btn btn-danger btn-sm' data-bs-target='#modalDeletarCate" . $categoria["id"] . "' data-bs-toggle='modal' data-bs-dismiss='modal'>Excluir</button>
                            </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<?php
require "../template/footer.php";
require "../validarInput.php";
?>