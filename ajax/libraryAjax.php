<?php
  $ajaxRequest = true;
  require_once "../config/app.php";

  if(isset($_POST['libro-libro-nombre']) || isset($_POST['name-book'])) {
    require_once "../controllers/libraryController.php";

    $lc = new LibraryController();

    // traemos la lista de libros
    if(isset($_POST['name-book']) && isset($_POST['get'])) {
      echo $lc->getListBooks();
    }

    // registramos reserva de libro
    if(isset($_POST['libro-id-libro']) && isset($_POST['libro-dni']) && isset($_POST['libro-email'])) {
      echo $lc->addLibraryController();
    }
  } else {
    session_start(["name" => NAMESESSION]);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login");
    exit();
  }