<?php
  if($ajaxRequest) {
    require_once "../models/BookModel.php";
  } else {
    require_once "./models/BookModel.php";
  }

  class BookController extends BookModel {
    // crear nuevo libro
    public function addBookController() {
      $titulo = MainModel::clearString($_POST['libro-titulo-reg']);
      $autor = MainModel::clearString($_POST['libro-autor-reg']);
      $serie = MainModel::clearString($_POST['libro-serie-reg']);
      $categoria = MainModel::clearString($_POST['libro-categoria-reg']);

      //comprobamos campos vacios obligatorios
      if($titulo == "" || $autor == "" || $serie == "" || $categoria == "") {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No has llenado todos los campos obligatorios.", "error"));

        exit();
      }

      // verificar integridad de los datos
      if(MainModel::verifyInfo("[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\22 ]{5,150}", $titulo)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El TITULO no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{10,100}", $autor)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El AUTOR no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-Z0-9$@.-]{7,100}", $serie)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "La SERIE no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\22]{5,15}", $categoria)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "La CATEGORIA no coincide con el formato solicitado.", "error"));

        exit();
      }

      // verificar si existe libro por serie
      $checkSerie = MainModel::executeSimpleQuery("SELECT serie FROM libro WHERE serie = '$serie'");
      if($checkSerie->rowCount() > 0) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Esta SERIE ya ha sido registrado.", "error"));

        exit();
      }

      // datos para registrar
      $bookInfo = [
        "titulo" => $titulo,
        "autor" => $autor,
        "serie" => $serie,
        "categoria" => $categoria
      ];

      // enviamos info para registrar
      $saveBook = BookModel::addBookModel($bookInfo);

      if($saveBook->rowCount() == 1) {
        $message = MainModel::alertContent("limpiar", "Libro Registrado", "Los datos del libro han sido registrados con exito.", "success");
      } else {
        $message = MainModel::alertContent("simple", "Algo salio mal.", "No hemos podido registrar el libro.", "error");
      }

      echo json_encode($message);
    }

    // actualizamos el estado
    public function updateStateBook() {
      $idLibro = MainModel::decryption($_POST['id-libro']);
      $idLibro = MainModel::clearString($idLibro);

      if($idLibro == "") {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Usted esta intentando hacer daño al sistema, no lo haga.", "error"));

        exit();
      }

      // comprobamos si existe la recepcion
      $checkBook = MainModel::executeSimpleQuery("SELECT idLibro, estado FROM libro WHERE idLibro = '$idLibro'");

      if($checkBook->rowCount() <= 0) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No hemos encontrado el libro en el sistema.", "error"));

        exit();
      } else {
        $row = $checkBook->fetch();
      }

      if($row['estado'] == "Reservado") {
        $state = "Entregado";
      }

      if($row['estado'] == "Entregado") {
        $state = "Libre";
      }

      $info = [
        "idLibro" => $idLibro,
        "estado" => $state,
      ];

      $updateState = BookModel::updateStateBookModel($info);

      if($updateState->rowCount() == 1) {
        $message = MainModel::alertContent("recargar", "Estado Actualizado", "Ud. ha marcado esta solicitud como ENTREGADO.", "success");
      } else {
        $message = MainModel::alertContent("simple", "Algo salio mal.", "No hemos podido actualizar el estado del libro.", "error");
      }

      echo json_encode($message);
    }
  }