<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fab fa-dashcube fa-fw"></i> &nbsp; DASHBOARD
  </h3>
  <p class="text-justify">
    Esta es la parte principal, desde aqui podra accder de forma rápida a donde quiere llegar, a demás ver ciertos datos interesantes. .
  </p>
</div>

<!-- Content -->
<div class="full-box tile-container">
  <?php
    if($_SESSION['privilegio'] == 3 || $_SESSION['privilegio'] == 1) {
      require_once "./controllers/libraryController.php";
      $lc = new LibraryController();
      $totalRequest = $lc->getTotalRequest();
  ?>
  <a href="<?php echo SERVERURL; ?>book-reservation" class="tile">
    <div class="tile-tittle">Biblioteca</div>
    <div class="tile-icon">
      <i class="fas fa-book fa-fw"></i>
      <p><?php echo $totalRequest->rowCount(); ?> Solicitudes de Prestamo</p>
    </div>
  </a>
  <?php } ?>

  <?php
    if($_SESSION['privilegio'] == 2 || $_SESSION['privilegio'] == 1) {
      require_once "./controllers/procedureController.php";
      $pc = new ProcedureController();
      $totalProcedures = $pc->getTotalProcedures();
  ?>
  <a href="<?php echo SERVERURL; ?>desk-recents" class="tile">
    <div class="tile-tittle">Mesa de Parte</div>
    <div class="tile-icon">
      <i class="fas fa-clipboard-list fa-fw"></i>
      <p><?php echo $totalProcedures->rowCount(); ?> Solicitudes</p>
    </div>
  </a>
  <?php } ?>

  <?php
    if($_SESSION['privilegio'] == 1) {
      require_once "./controllers/userController.php";
      $uc = new UserController();
      $totalUsers = $uc->getUserController('count', 0);
  ?>
  <a href="<?php echo SERVERURL; ?>user-list" class="tile">
    <div class="tile-tittle">Usuarios</div>
    <div class="tile-icon">
      <i class="fas fa-user-secret fa-fw"></i>
      <p><?php echo $totalUsers->rowCount(); ?> Registrados</p>
    </div>
  </a>
  <?php } ?>
</div>