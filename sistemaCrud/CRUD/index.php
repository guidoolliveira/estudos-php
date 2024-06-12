<?php
require "template/sidebar.php";
?>
<div class="container">
<h2 class="mb-0 mt-3"> <i class="fa-solid fa-home me-3 ms-2 fs-2"></i>Página Inicial</h2>
<hr class="mt-0">
<div class="d-flex gap-4 flex-wrap flex-lg-nowrap mt-4">
  <div class="px-2 w-100 d-flex bg-primary bg-gradient shadow rounded">
    <div>
      <a class="fs-3 text-white" href="cruds/instrutor/instrutores.php">Instrutores<i class="fa-solid fa-users ms-2 fs-4"></i> </a>
      <p class="fs-5">Total:
        <?php
        $sql = "SELECT * FROM instrutores;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->rowCount();
        echo $resultado;
      ?></p>
    </div>
  </div>
  <div class="d-flex w-100 px-2 bg-secundary bg-gradient shadow rounded">
    <div>
      <a class="fs-3 text-white" href="cruds/funcionario/funcionarios.php">Funcionários<i class="fa-solid fa-users ms-2 fs-4"></i></a>
      <p class="fs-5">Total:
        <?php
        $sql = "SELECT * FROM login;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->rowCount();
        echo $resultado;
      ?></p>
    </div>
  </div>
  <div class="px-2 d-flex w-100 bg-danger bg-gradient shadow rounded">
    <div>
      <a class="fs-3 text-white" href="cruds/produto/produtos.php">Produtos<i class="fa-solid fa-cart-shopping ms-2 fs-4"></i></a>
      <p class="fs-5">Total:
        <?php
        $sql = "SELECT * FROM produtos;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->rowCount();
        echo $resultado;
      ?></p>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
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
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<?php
  require "template/footer.php";
?>