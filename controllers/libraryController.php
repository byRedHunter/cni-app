<?php
  if($ajaxRequest) {
    require_once "../models/LibraryModel.php";
  } else {
    require_once "./models/LibraryModel.php";
  }

  class LibraryController extends LibraryModel {
    // registrar solicitud
    public function addLibraryController() {
      $tipoUsuario = $_POST['libro-tipo-usuario'];

      $dni = MainModel::clearString($_POST['libro-dni']);
      $nombre = MainModel::clearString($_POST['libro-nombre']);
      $apellido = MainModel::clearString($_POST['libro-apellido']);
      $email = MainModel::clearString($_POST['libro-email']);
      $celular = MainModel::clearString($_POST['libro-celular']);

      $fechaRecojo = $_POST['libro-fecha-recojo'];
      $fechaDevol = $_POST['libro-fecha-devol'];

      $libroId = $_POST['libro-id-libro'];

      // comprobamos campos obligatorios
      if($dni == "" || $nombre == "" || $apellido == "" || $email == "" || $celular == "" || $fechaRecojo == "" || $fechaDevol == "" || $tipoUsuario == "0" || $libroId == "") {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No has completado todos los campos obligatorios.", "error"));

        exit();
      }

      // integridad de los datos
      if(MainModel::verifyInfo("[0-9]{8}", $dni)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El DNI no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El NOMBRE no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El APELLIDO no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Ha ingresado un email invalido.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[0-9]{9}", $celular)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El CELULAR no coincide con el formato solicitado.", "error"));

        exit();
      }

      if( $tipoUsuario < 1 || $tipoUsuario > 2) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El TIPO DE USUARIO seleccionado no es válido.", "error"));

        exit();
      }

      if(MainModel::verifyDate($fechaRecojo)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Fecha de recojo no es válido.", "error"));

        exit();
      }

      if(MainModel::verifyDate($fechaDevol)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Fecha de devolucion no es válido.", "error"));

        exit();
      }

      $solicitanteInfo = [
        "dni" => $dni,
        "nombre" => $nombre,
        "apellido" => $apellido,
        "email" => $email,
        "celular" => $celular,
      ];

      $existSolicitante = SolicitanteModel::getSolicitanteModel(['dni' => $dni]);

      if($existSolicitante->rowCount() > 0) {
        // existe solicitante
        $row = $existSolicitante->fetch();

        $idSolicitante = $row['idSolicitante'];

        // si son diferentes actualizamos
        if($nombre != $row['nombre'] || $apellido != $row['apellido'] || $email != $row['email'] || $celular != $row['celular']) {
          SolicitanteModel::updateSolicitanteModel($solicitanteInfo);
        }
      } else {
        // no existe solicitante
        $result = SolicitanteModel::addSolicitanteModel($solicitanteInfo);

        if($result['query']->rowCount() == 1) {
          $idSolicitante = $result['id'];
        }
      }

      $libraryInfo = [
        "tipoSolicitante" => $tipoUsuario,
        "fechaRecojo" => $fechaRecojo,
        "fechaDevolucion" => $fechaDevol,
        "idSolicitante" => $idSolicitante,
        "idLibro" => $libroId,
        "codigo" => MainModel::codeToRegister(),
      ];

      // registramos la solicitud_libro
      $saveInfo = LibraryModel::addSolicitudLibro($libraryInfo);

      if($saveInfo->rowCount() == 1) {
        $message = MainModel::alertContent("limpiar", "Solicitud de Prestamo Registrado", "¡IMPORTANTE! Su codigo de prestamo es " . $libraryInfo['codigo'] . " guardelo.", "success");
      } else {
        $message = MainModel::alertContent("simple", "Algo salio mal.", "No hemos podido registrar su reserva de libro, intentelo más tarde.", "error");
      }

      echo json_encode($message);
    }

    // obtener lista de libros
    public function getListBooks() {
      $books = array();
      $data = BookModel::getListBooksModel(['name' => $_POST['name-book']]);

      if($data->rowCount() != 0) {
        $row = $data->fetchAll();

        $message = [
          'error' => false,
          'message' => 'Seleccione su libro',
          'data' => $row
        ];
      } else {
        $message = [
          'error' => true,
          'message' => 'No existe libros',
          'data' => []
        ];
      }

      echo json_encode($message);
    }

    // obtener datos totales de reservas de libro
    public function getTotalRequest() {
      $query = MainModel::connect()->prepare("SELECT idSolicitudLibro FROM solicitud_libro");

      $query->execute();

      return $query;
    }
  }