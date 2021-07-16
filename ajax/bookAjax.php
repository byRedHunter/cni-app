<?php
  $ajaxRequest = true;
  require_once "../config/app.php";

  if(isset($_POST['libro-titulo-reg']) || isset($_POST['id-libro']) || isset($_POST['libro-id-up'])) {
    require_once "../controllers/bookController.php";
    $book = new BookController();

    //registramos un nuevo libro
    if(isset($_POST['libro-titulo-reg']) && isset($_POST['libro-serie-reg']) && isset($_POST['libro-autor-reg'])) {
      echo $book->addBookController();
    }

    //actualizamos el estado del libro
    if(isset($_POST['id-libro'])) {
      echo $book->updateStateBook();
    }

    //actualizamos datos del libro
    if(isset($_POST['libro-id-up'])) {
      echo $book->updateBookController();
    }
  } else {
    session_start(["name" => NAMESESSION]);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login");
    exit();
  }