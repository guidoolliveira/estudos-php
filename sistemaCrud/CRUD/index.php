<?php
require "template/sidebar.php";
$tamanhoCol = "";
if ($_SESSION["acesso"] == 1) {
  $tamanhoCol = "col-xl-3";
} else {
  $tamanhoCol = "col-xl-4";
}
?>
<div class="container">
  <h2 class="mb-0 mt-3"> <i class="fa-solid fa-home me-3 ms-2 fs-2"></i>Página Inicial</h2>
  <hr class="mt-0">
  <div class="row mt-4">
    <div class="<?php echo $tamanhoCol; ?> col-md-6">
      <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">Cursos</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a class="small text-white stretched-link" href="cruds/curso/cursos.php">Ver Detalhes</a>
          <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
      </div>
    </div>
    <div class="<?php echo $tamanhoCol; ?> col-md-6">
      <div class="card bg-warning bg-gradient text-white mb-4">
        <div class="card-body">Instrutores</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a class="small text-white stretched-link" href="cruds/instrutor/instrutores.php">Ver Detalhes</a>
          <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
      </div>
    </div>
    <div class="<?php echo $tamanhoCol; ?> col-md-6">
      <div class="card bg-success bg-gradient text-white mb-4">
        <div class="card-body">Produtos</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a class="small text-white stretched-link" href="cruds/produto/produtos.php">Ver Detalhes</a>
          <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
      </div>
    </div>
    <?php
    if ($_SESSION['acesso'] == 1) {
      echo '<div class="col-xl-3 col-md-6">
      <div class="card bg-danger bg-gradient text-white mb-4">
        <div class="card-body">Fucionários</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a class="small text-white stretched-link" href="cruds/funcionario/funcionarios.php">Ver Detalhes</a>
          <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
      </div>
    </div>
    <hr>
  </div>';
    }
    ?>
    <!-- <div class="">
      <h3><i class="fa-solid fa-scroll me-3 ms-2 fs-3 mt-4"></i>Relatório</h3>
    </div> -->
    <?php
    $sql = "SELECT i.* FROM instrutores as i LEFT JOIN cursos as c on i.idinstrutores = c.idinstrutores where c.idinstrutores IS NULL;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $relatorios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($relatorios) > 0) { ?>
      <div class="table-responsive mt-5">
        <table class="table table-dark table-striped table-hover table-bordered">
          <thead class="">
            <h4 class="text-center text-warning">Intrutores que não estão direncionando cursos!</h4>
            <tr class="text-center">
              <th>Instrutor</th>
              <th>Especialização</th>
              <th>Celular</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($relatorios as $relatorio) {
              echo "<tr  class='text-center'>";
              echo "<td>" . $relatorio["nome"] . "</td>";
              $idespecializacao = $relatorio["idespecializacao"];
              $sql = "SELECT nomeEspecializacao FROM especializacao WHERE id = :idespecializacao ";
              $stmt = $conn->prepare($sql);
              $stmt->bindValue("idespecializacao", $idespecializacao);
              $stmt->execute();
              $especializacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($especializacoes as $especializacao) {
                echo "<td class='text-nowrap'>" . $especializacao["nomeEspecializacao"] . "</td>";
              }
              echo "<td>" . $relatorio["celular"] . "</td>";
            }
            ?>
          </tbody>
        </table>
      </div>
    <?php
    }
    
    ?>
  </div>

  <?php
  require "template/footer.php";
  ?>