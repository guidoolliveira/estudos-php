<?php
session_start();
if (!isset($_SESSION["idusers"])) {
  header("Location: ../login/login.php");
}
require "header.php";
require "../../dbconfig/conexao.php";
$id = $_SESSION["idusers"];
$sql = "SELECT * FROM login WHERE id= :id;";
$stmt = $conn->prepare($sql);
$stmt->bindValue("id", $id);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $dados)
?>
<div id="bdSidebar" data-bs-backdrop="false" data-bs-scroll="true" class="h-100 d-flex flex-column bg-body shadow flex-shrink-0 p-3 text-white offcanvas offcanvas-start">
  <div class="d-flex justify-content-between">
    <a href="../../index.php" class="navbar-brand">
      <h5><i style="font-size: 28px;" class="fa-solid fa-shop me-2"></i> PresidiOnStock</h5>
    </a>
    <span class="mt-1 me-0"><button type="button" class="btn-close text-reset"
        data-bs-dismiss="offcanvas"></button></span>
  </div>
  <hr>
  <ul id="sidebar" class="nav nav-pills flex-column mb-auto">
    <li class="nav-item mb-2">
      <a href="../../index.php" class="active text-decoration-none text-white rounded-1 d-block w-100">
        <i class="text-center fa-solid fa-home"></i>
        Página inicial
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="../instrutor/instrutores.php" class="active text-decoration-none text-white rounded-1 d-block w-100">
        <i class="text-center fa-solid fa-users"></i>
        Instrutores
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="../produto/produtos.php" class="active text-decoration-none text-white rounded-1 d-block w-100">
        <i class="fa-solid fa-cart-shopping"></i>
        Produtos
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="" class="active text-decoration-none text-white rounded-1 d-block w-100">
        <i class="fa-solid fa-file-circle-exclamation"></i>
        Relatórios
      </a>
    </li>
    <?php
      if($_SESSION["acesso"] == 1){
        
        echo '<hr>
        <h5 class="fs-5">Painel Administrativo</h5>
    <li class="nav-item mb-2">
      <a href="../funcionario/funcionarios.php" class="active text-decoration-none text-white rounded-1 d-block w-100">
        <i class="text-center fa-solid fa-users"></i>
        Funcionários
      </a>
    </li>';
      }
    
    ?>
    
  </ul>
  <hr class="my-2">
  <div class="d-flex" id="footer-nav">
    <span>
      <i class="fa-solid fa-user"></i>
      <small class="mb-0">

        <?php
        echo $dados["usuario"];
        ?>
      </small>
      <br>
      <small>
        <i class="fa-solid fa-envelope"></i>
        <?php
        echo $dados["email"];
        ?></small>
    </span>
  </div>
</div>
<div class="w-100">
  <div class="p-3 d-flex text-white bg-body shadow justify-content-between ">
    <div class="d-flex mt-1"> <a href="" class="text-white" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
        <i class="fa-solid fa-bars fs-5"></i>
      </a>
      <a href="../../index.php" class="ms-3 fw-semibold text-white text-decoration-none">PresidiOnStock</a>
    </div>
    <button type="button" class="btn btn-outline-danger btn-sm " data-bs-toggle="modal"
      data-bs-target="#modalLogOut">
      Sair da conta
    </button>

    <!-- Modal Sair -->
    <div class="modal fade" id="modalLogOut" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog" id="modalLogOut">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Você deseja sair da conta?</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Você terá que preencher seu dados novamente!
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <a href="../login/deslogar.php"><button type="button" class="btn btn-danger">Sair da conta</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php
require "footer.php";
?>