<?php
require "../template/sidebar.php";
$sql = "SELECT * FROM instrutores;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$instrutores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container mt-3">
  <h2 class="mb-0 mt-3"><i class="fa-solid fa-users me-3 ms-2 fs-2"></i>Instrutores: <?php
  $sql = "SELECT * FROM instrutores;";
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
              <a href='instrutores.php' class='btn-close'></a>
          </div>
      </div>";
  }
  if (isset($_GET["nomeEspecializacao"])) {
    echo '<div style="top: 3rem" class="">
        <div class="alert alert-success alert-dismissible fade show fw-semibold text-center" role="alert">
            A especialização ' . $_GET["nomeEspecializacao"] . ' foi cadastrada  com sucesso!
            <a href="instrutores.php" class="btn-close"></a>
        </div>
    </div>';
  }
  if (isset($_GET["deletar"]) && $_GET["deletar"] == "instrutor") {
    echo '<div style="top: 3rem" class="">
        <div class="alert alert-warning alert-dismissible fade show fw-semibold text-center" role="alert">
            O instrutor ' . $_GET["nome-instrutor"] . ' foi deletado com sucesso!
            <a href="instrutores.php" class="btn-close"></a>
        </div>
    </div>';
  }
  if (isset($_GET["nome-especializacao"]) && $_GET["deletar"] == "ok") {
    echo '<div style="top: 3rem" class="">
        <div class="alert alert-warning alert-dismissible fade show fw-semibold text-center" role="alert">
            A Especialização ' . $_GET["nome-especializacao"] . ' foi deletada com sucesso!
            <a href="instrutores.php" class="btn-close"></a>
        </div>
    </div>';
  }
  if (isset($_GET["edit"]) && $_GET["edit"] == "ok") {
    echo '<div style="top: 3rem" class="">
        <div class="alert alert-success alert-dismissible fade show fw-semibold text-center" role="alert">
            O instrutor ' . $_GET["nome-instrutor"] . ' foi editado com sucesso!
            <a href="instrutores.php" class="btn-close"></a>
        </div>
    </div>';
  }
  if (isset($_GET["success"]) && $_GET["success"] == "ok") {
    echo '<div style="top: 3rem" class="">
        <div class="alert alert-success alert-dismissible fade show fw-semibold text-center" role="alert">
            O instrutor ' . $_GET["nome-instrutor"] . ' foi cadastrado com sucesso!
            <a href="instrutores.php" class="btn-close"></a>
        </div>
    </div>';
  }

  if ($_SESSION["acesso"] == 1) {
    echo '<button class="btn btn-primary mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#modalCadastro">Cadastrar Instrutor</button> 
    <div class="btn-group">
  <button type="button" class="btn btn-primary dropdown-toggle mt-2 mb-3" data-bs-toggle="dropdown" aria-expanded="false"> Especializações
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalCadEspecializacao" href="#">Cadastrar</a></li>
    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalVisualizarEspec" href="#">Visualizar</a></li>
  </ul>
</div>';
  }
  ?>

  <?php
  if (count($instrutores) > 0) { ?>
    <div class="table-responsive">
      <table class="table table-dark table-striped">
        <thead class="">
          <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Especialização</th>
            <th>Celular</th>
            <?php
            if ($_SESSION["acesso"] == 1) {
              echo "<th>Ações</th>";
            }
            ?>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($instrutores as $instrutor) {
            echo "<tr>";
            echo "<td>" . $instrutor["idinstrutores"] . "</td>";
            echo "<td class='text-nowrap'>" . $instrutor["nome"] . "</td>";
            $idespecializacao = $instrutor["idespecializacao"];
            $sql = "SELECT nomeEspecializacao FROM especializacao WHERE id = :idespecializacao ";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("idespecializacao", $idespecializacao);
            $stmt->execute();
            $especializacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($especializacoes as $especializacao) {
              echo "<td class='text-nowrap'>" . $especializacao["nomeEspecializacao"] . "</td>";
            }
            echo "<td  class='text-nowrap'>" . $instrutor["celular"] . "</td>";
            if ($_SESSION["acesso"] == 1) {
              echo "<td class='text-nowrap' ><span>
              <button class='btn btn-danger btn-sm ' data-bs-toggle='modal' data-bs-target='#modalDeletar" . $instrutor['idinstrutores'] . "'>Excluir</button>
              <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditar" . $instrutor['idinstrutores'] . "'>Editar</button>
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
<!-- Modal Cadastrar Instrutor-->
<div class="modal fade" id="modalCadastro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar Instrutor</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex justify-content-center">
        <form action="cadastrar.php" method="post" data-parsley-validate novalidate>
          <div class="row">
            <div class="mb-3 col-12">
              <span class="form-label">Nome</span>
              <input type="text" class="form-control" name="nome" placeholder="Nome do instrutor" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3 col-sm-6">
              <span class="form-label">Especialização</span>
              <select class="form-select" name="idespecializacao" required>
                <?php $sql = "SELECT * FROM especializacao;";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $especializacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($especializacoes as $especializacao) {
                  echo "<option value=" . $especializacao["id"] . ">" . $especializacao["nomeEspecializacao"] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3 col-sm-6">
              <span class="form-label">Celular</span>
              <input type="text" class="form-control celular" name="celular" placeholder="xx xxxxx xxxx" maxlength="15"
                required>
            </div>
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

<!-- Modal Deletar Instrutor -->
<?php foreach ($instrutores as $instrutor) { ?>
  <div class="modal fade" id="modalDeletar<?php echo $instrutor['idinstrutores']; ?>" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir o instrutor <?php
          echo $instrutor['nome']
            ?>? </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <span>Está ação é irreversível!</span>
          <form method='post' action='deletar.php'>
            <input type='hidden' name='id' value="<?php echo $instrutor['idinstrutores']; ?>" />
            <input type='hidden' name='nome' value="<?php echo $instrutor['nome']; ?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Excluir</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Editar Instrutor -->
  <div class="modal fade" id="modalEditar<?php echo $instrutor['idinstrutores']; ?>" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Instrutor</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="editar.php" method="post" data-parsley-validate novalidate>
            <input type="hidden" name="id" value="<?php echo $instrutor['idinstrutores']; ?>">
            <div class="mb-3 mx-4">
              <span class="form-label">Nome</span>
              <input type="text" class="form-control" name="nome" value="<?php echo $instrutor['nome']; ?>" required>
            </div>
            <div class="mb-3 mx-4">
              <span class="form-label">Especialização</span>
              <select class="form-select" name="idespecializacao" required>
                <?php
                $sql = "SELECT * FROM especializacao;";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $especializacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($especializacoes as $especializacao) {
                  if ($especializacao["id"] == $instrutor["idespecializacao"]) {
                    echo "<option value='" . $especializacao["id"] . "' selected>" . $especializacao["nomeEspecializacao"] . "</option>";
                  } else {
                    echo "<option value='" . $especializacao["id"] . "'>" . $especializacao["nomeEspecializacao"] . "</option>";
                  }
                }
                ?>
              </select>
            </div>
            <div class="mb-3 mx-4">
              <span class="form-label">Celular</span>
              <input type="text" class="form-control celular" name="celular" value="<?php echo $instrutor['celular']; ?>"
                maxlength="15" required>
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
<!-- Modal Cadastrar Especialização -->
<div class="modal fade" id="modalCadEspecializacao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar Especialização</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../especializacao/cadastrar.php" method="post" data-parsley-validate novalidate>
          <div class="mb-3 mx-4">
            <span class="form-label">Nome</span>
            <input type="text" class="form-control" name="nomeEspecializacao" placeholder="Especialização " required>
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

<!-- Modal Visualizar Especializações -->
<div class="modal fade" id="modalVisualizarEspec" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Visualizar Especializações</h1>
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
              $sql = "SELECT * FROM especializacao";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $especializacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($especializacoes as $especializacao) {
                echo "<td  class='text-nowrap'>" . $especializacao["id"] . "</td>";
                echo "<td  class='text-nowrap'>" . $especializacao["nomeEspecializacao"] . "</td>";
                if ($_SESSION["acesso"] == 1) {
                  echo "<td class='text-nowrap' ><span>
                <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditarEspec" . $especializacao["id"] . "' data-bs-dismiss='modal'>Editar</button>
                <button class='btn btn-danger btn-sm' data-bs-target='#modalDeletarEspec" . $especializacao["id"] . "' data-bs-toggle='modal' data-bs-dismiss='modal'>Excluir</button>
                </td>";
                }
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

<!-- Modal Editar Especialização -->
<?php
foreach ($especializacoes as $especializacao) {
  ?>
  <div class="modal fade" id="modalEditarEspec<?php echo $especializacao["id"]; ?>" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Especialização</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../especializacao/editar.php" method="post" data-parsley-validate novalidate>
            <input type="hidden" name="id" value="<?php echo $especializacao["id"]; ?>">
            <div class="mb-3 mx-4">
              <span class="form-label">Nome</span>
              <input type="text" class="form-control" name="nomeEspecializacao"
                value="<?php echo $especializacao["nomeEspecializacao"]; ?>" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" name="submit" class="btn btn-primary">Editar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Deletar Especialização -->
  <div class="modal fade" id="modalDeletarEspec<?php echo $especializacao["id"]; ?>" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Deletar Especialização</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Deseja deletar a especialização <?php echo $especializacao["nomeEspecializacao"];?>?</p>
          <form action="../especializacao/deletar.php" method="post">
            <input type="hidden" name="id" value="<?php echo $especializacao["id"]; ?>">
            <input type="hidden" name="nome" value="<?php echo $especializacao["nomeEspecializacao"]; ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" name="submit" class="btn btn-danger">Deletar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>
 <div class="modal fade" id="exampleModalToggle" aria-labelledby="exampleModalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Modal 1</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Show a second modal and hide this one with the button below.
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Open second modal</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModalToggle2" aria-labelledby="exampleModalToggleLabel2" tabindex="-1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Modal 2</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Hide this modal and show the first with the button below.
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Back to first</button>
          </div>
        </div>
      </div>
    </div>
    <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Open first modal</button>


</script>
<?php
require "../template/footer.php";
require "../validarInput.php";
?>