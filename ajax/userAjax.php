<?php
  $ajaxRequest = true;
  require_once "../config/app.php";

  if(isset($_POST['usuario-dni-reg']) || isset($_POST['usuario-id-del'])) {
    require_once "../controllers/userController.php";
    $user = new UserController();

    // registrar nuevo usuario
    if(isset($_POST['usuario-dni-reg']) && isset($_POST['usuario-nombre-reg'])) {
      echo $user->addUserController();
    }

    // eliminar usuario
    if(isset($_POST['usuario-id-del'])) {
      echo $user->deleteUserController();
    }
  } else {
    session_start(["name" => NAMESESSION]);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login");
    exit();
  }