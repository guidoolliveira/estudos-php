<?php
session_start();
if (!isset($_SESSION["idusers"])) {
  header("Location: login.php");
}
require "template/header.php";
require "template/sidebar.php";
require "dbconfig/conexao.php";
?>
<div class="container">
<h2 class="mb-0 mt-3 py-0">Página Inicial</h2>
<hr class="mt-0">
<div class="d-flex gap-4 flex-wrap flex-lg-nowrap mt-4">
  <div class="px-2 w-100 d-flex bg-primary bg-gradient shadow rounded">
    <div>
      <a class="fs-3 text-white" href="instrutores.php">Instrutores <i class="fa-solid fa-users ms-2 fs-4"></i> </a>
      <p class="fs-5">Total:
        <?php
        $sql = "SELECT * FROM instrutores;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        echo $result;
      ?></p>
    </div>
  </div>
  <div class="d-flex w-100 px-2 bg-secundary bg-gradient shadow rounded">
    <div>
      <a class="fs-3 text-decoration-none text-white" href="">Funcionários</a>
      <p class="fs-5">Total: 5</p>
    </div>
  </div>
  <div class="px-2 d-flex w-100 bg-danger bg-gradient shadow rounded">
    <div>
      <a class="fs-3 text-decoration-none text-white" href="verify/deslogar.php">Funcionários</a>
      <p class="fs-5">Total: 5</p>
    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php
  require "template/footer.php";
?>