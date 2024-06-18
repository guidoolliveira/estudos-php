<?php
require "../template/sidebar.php";
$sql = "SELECT * FROM produtos;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container mt-3">
    <h2 class="mb-0 mt-3"><i class="fa-solid fa-cart-shopping me-3 ms-2 fs-2"></i>Produtos:
        <?php
        $sql = "SELECT * FROM produtos;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->rowCount();
        echo $resultado;
        ?></h2>
    <hr class="mt-0">
    <?php
    if (isset($_GET["alerta"])) {
        $corAlerta = "";
        $mensagemAlerta = "";
        if ($_GET["alerta"] == "preencher-campos") {
            $corAlerta = "danger";
            $mensagemAlerta = "Preencha todos os campos!";
        }
        if ($_GET["alerta"] == "cadastroProduto") {
            $corAlerta = "success";
            $mensagemAlerta = "O produto " . $_GET['nome-produto'] . " foi cadatrado com sucesso!";
        }
        if ($_GET["alerta"] == "editadoProduto") {
            $corAlerta = "success";
            $mensagemAlerta = "O produto " . $_GET['nome-produto'] . " foi editado com sucesso!";
        }
        if ($_GET["alerta"] == "deletadoProduto") {
            $corAlerta = "success";
            $mensagemAlerta = "O produto " . $_GET['nome-produto'] . " foi deletado com sucesso!";
        }
        if ($_GET["alerta"] == "cadastroCategoria") {
            $corAlerta = "success";
            $mensagemAlerta = "A categoria " . $_GET['nome-categoria'] . " foi cadatrada com sucesso!";
        }
        if ($_GET["alerta"] == "editadoCategoria") {
            $corAlerta = "success";
            $mensagemAlerta = "A categoria " . $_GET['nome-categoria'] . " foi editada com sucesso!";
        }
        if ($_GET["alerta"] == "deletadoCategoria") {
            $corAlerta = "success";
            $mensagemAlerta = "A categoria " . $_GET['nome-categoria'] . " foi deletada com sucesso!";
        }
        echo "
          <div class='alert alert-$corAlerta alert-dismissible fade show fw-semibold text-center' role='alert'>
            <span>$mensagemAlerta</span>
            <a href='produtos.php' class='btn-close'></a>
          </div>";
    }
    if ($_SESSION["acesso"] == 1) {
        echo '<button class="btn btn-primary mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#modalCadastrarProduto">Cadastrar Produto</button>
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
            <table class="table table-dark table-striped table-hover table-bordered">
                <thead class="">
                    <tr class="text-center">
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
                        echo "<tr class='text-center'>";
                        echo "<td>" . $produto["id"] . "</td>";
                        echo "<td>" . $produto["nome"] . "</td>";
                        echo "<td class='text-nowrap' >R$ " . $preco . "</td>";
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
                            echo "<td class='text-nowrap''>
                                <span>
                                <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditar" . $produto['id'] . "'>Editar</button>
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
        echo '<h3 class="text-warning text-center">Ainda não há produtos cadastrados!</h3>';
    } ?>
</div>
</div>
<?php foreach ($produtos as $produto) { ?>
    <!-- Modal deletar -->
    <div class="modal fade" id="modalDeletar<?php echo $produto['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir o produto <?php
                                                                                            echo $produto['nome'] ?>?</h1>
                    <a href='produtos.php' class='btn-close'></a>
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
    <div class="modal fade" id="modalEditar<?php echo $produto['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Produto</h1>
                    <a href='produtos.php' class='btn-close'></a>
                </div>
                <div class="modal-body">
                    <form action="editar.php" method="post" data-parsley-validate novalidate>
                        <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
                        <div class="mb-3 mx-4">
                            <label for="nomeProduto" class="form-label">Nome</label for="">
                            <input type="text" class="form-control" id="nomeProduto" name="nome" value="<?php echo $produto['nome']; ?>" required>
                        </div>
                        <div class="mx-4">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="quantidade" class="form-label">Quantidade</label>
                                    <input type="number" class="form-control" name="quantidade" id="quantidade" value="<?php echo $produto['quantidade']; ?>" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="preco" class="form-label">Preço</label>
                                    <input type="number" step="0.01" id="preco" class="form-control" name="preco" value="<?php echo $produto['preco']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mx-4">
                            <label for="fornecedor" class="form-label">Fornecedor</label>
                            <input type="text" class="form-control" id="fornecedor" name="fornecedor" value="<?php echo $produto['fornecedor']; ?>" id="" required>
                        </div>
                        <div class="mb-3 mx-4">
                            <label for="idcategoria" class="form-label">Categoria</label>
                            <a class="text-decoration-none fs-5" data-bs-toggle="modal" data-bs-target="#modalCadCategoria">+</a>
                            <select class="form-select" id="idcategoria" name="idcategoria" required>
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
                    <button type="submit" name="submit" class="btn btn-primary">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<!-- Modal Cadastrar Produto -->
<div class="modal fade" id="modalCadastrarProduto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar Produto</h1>
                <a href='produtos.php' class='btn-close'></a>
            </div>
            <div class="modal-body">
                <form action="cadastrar.php" method="post" data-parsley-validate novalidate>
                    <input type="hidden" name="id">
                    <div class="mb-3 mx-4">
                        <label for="nome" class="form-label">Nome<span class="text-danger fw-bold">*</span></label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>
                    <div class="mx-4">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="quantidade" class="form-label">Quantidade<span class="text-danger fw-bold">*</span></label>
                                <input type="number" class="form-control" id="quantidade" name="quantidade" value="" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="preco" class="form-label">Preço<span class="text-danger fw-bold">*</span></label>
                                <input type="number" step="0.01" class="form-control" name="preco" id="preco" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 mx-4">
                        <label for="fornecedor" class="form-label">Fornecedor<span class="text-danger fw-bold">*</span></label>
                        <input type="text" class="form-control" name="fornecedor" value="" id="fornecedor" required>
                    </div>
                    <div class="mb-3 mx-4">
                        <label for="idcategoria" class="form-label">Categoria<span class="text-danger fw-bold">*</span></label>
                        <a class="text-decoration-none fs-5" data-bs-toggle="modal" data-bs-target="#modalCadCategoria">+</a>
                        <select class="form-select" name="idcategoria" id="idcategoria" required>
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
<div class="modal fade" id="modalCadCategoria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar Categoria</h1>
                <a href='produtos.php' class='btn-close'></a>
            </div>
            <div class="modal-body">
                <form action="../categoria/cadastrar.php" method="post" data-parsley-validate novalidate>
                    <div class="mb-3 mx-4">
                        <label for="nomeCategoria" class="form-label">Nome<span class="text-danger fw-bold">*</span></label>
                        <input type="text" class="form-control" id="nomeCategoria" name="nomeCategoria" placeholder="Categoria " required>
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

<!-- Modal Visualizar Categorias -->
<div class="modal fade" id="modalVisualizarCatego" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Visualizar Categorias</h1>
                <a href='produtos.php' class='btn-close'></a>
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
                                <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditarCatego" . $categoria["id"] . "' data-bs-dismiss='modal'>Editar</button>
                                <button class='btn btn-danger btn-sm'                   data-bs-target='#modalDeletarCatego" . $categoria["id"] . "' data-bs-toggle='modal' data-bs-dismiss='modal'>Excluir</button>
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
<!-- Modal Editar Categoria -->
<?php
foreach ($categorias as $categoria) {
?>
    <div class="modal fade" id="modalEditarCatego<?php echo $categoria["id"]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Categoria</h1>
                    <a href='produtos.php' class='btn-close'></a>
                </div>
                <div class="modal-body">
                    <form action="../categoria/editar.php" method="post" data-parsley-validate novalidate>
                        <input type="hidden" name="id" value="<?php echo $categoria["id"]; ?>">
                        <div class="mb-3 mx-4">
                            <label for="nomeCategoriaEdit" class="form-label">Nome<span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" name="nome" id="nomeCategoriaEdit" value="<?php echo $categoria["nome"]; ?>" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="submit" class="btn btn-primary">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Deletar Categoria -->
    <div class="modal fade" id="modalDeletarCatego<?php echo $categoria["id"]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Deletar Categoria <?php echo $categoria["nome"]; ?>?</h1>
                    <a href='produtos.php' class='btn-close'></a>
                </div>
                <div class="modal-body">
                    <p class="text-danger"><i class="fa-solid fa-circle-exclamation"></i> Essa ação ira apagar todos os produtos com essa categoria. </p>
                    <form action="../categoria/deletar.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $categoria["id"]; ?>">
                        <input type="hidden" name="nome" value="<?php echo $categoria["nome"]; ?>">
                </div>
                <div class="modal-footer">
                    <a href='produtos.php' class='btn btn-secondary'>Cancelar</a>
                    <button type="submit" name="submit" class="btn btn-danger">Deletar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
require "../template/footer.php";
require "../validarInput.php";
?>