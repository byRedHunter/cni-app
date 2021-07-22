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

      $changeBookState = MainModel::executeSimpleQuery("UPDATE libro SET estado = 'Reservado' WHERE idLibro = '$libroId'");

      if($changeBookState->rowCount() < 1) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Hubo un problema al reservar su libro.", "error"));

        exit();
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
          'message' => 'No hay libros disponibles',
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

    // paginacion de solicitudes
    public function paginatorLibraryController($page, $registers, $url) {
      $page = MainModel::clearString($page);
      $registers = MainModel::clearString($registers);

      $url = MainModel::clearString($url);
      $url = SERVERURL . $url . "/";

      $table = "";

      $page = (isset($page) && $page > 0) ? (int)$page : 1;
      $start = ($page > 0) ? (($page * $registers) - $registers) : 0;

      // todos
      $query = "SELECT SQL_CALC_FOUND_ROWS sl.idSolicitudLibro, sl.idSolicitante, sl.tipoSolicitante, sl.fechaRecojo, sl.fechaDevolucion, sl.codigo, sl.estado, s.dni, s.nombre, s.apellido, s.email, s.celular, l.idLibro, l.titulo, l.categoria  FROM solicitud_libro as sl INNER JOIN solicitante as s ON sl.idSolicitante = s.idSolicitante INNER JOIN libro as l ON sl.idLibro = l.idLibro ORDER BY sl.fechaRecojo DESC LIMIT $start, $registers";
      

      $connection = MainModel::connect();

      $data = $connection->query($query);
      $data = $data->fetchAll();

      $total = $connection->query("SELECT FOUND_ROWS()");
      $total = (int)$total->fetchColumn();
      
      $numPages = ceil($total / $registers);

      $table .= '
        <div class="table-responsive">
          <table class="table table-dark table-sm">
            <thead>
              <tr class="text-center roboto-medium">
                <th>#</th>
                <th>CODIGO</th>
                <th>
                  <span class="text-table">lskjlsdjfksdjfk</span>TITULO<span class="text-table">lskjlsdjfksdjfk</span>
                </th>
                <th>CATEGORIA</th>
                <th>ESTADO</th>
                <th>SOLICITANTE</th>
                <th>DNI</th>
                <th>EMAIL</th>
                <th>CELULAR</th>
                <th>TIPO</th>
                <th><span class="text-table">ls</span>RECOJO<span class="text-table">ls</span></th>
                <th>DEVOLUCION</th>
                <th>ENTREGAR</th>
              </tr>
            </thead>
            <tbody>';
      
      if($total > 0 && $page <= $numPages) {
        $counter = $start + 1;
        $regInit = $start + 1;

        foreach ($data as $row) {
          $tipoSolicitante = $row['tipoSolicitante'] == 1 ? 'Profesor' : 'Estudiante';
          $classes = CLASES[$row['tipoSolicitante']];

          $classState = ['Disponible' => 'success', 'Reservado' => 'warning', 'Entregado' => 'dark'];

          $state = $row['estado'] != 'Reservado' ? 'disabled' : null;

          $table .= '
          <tr class="text-center">
            <td>'.$counter.'</td>
            <td class="font-weight-bold">'.$row['codigo'].'</td>
            <td>'.$row['titulo'].'</td>
            <td>'.$row['categoria'].'</td>
            <td><span class="badge badge-'.$classState[$row['estado']].'">'.$row['estado'].'</span></td>
            <td>'.$row['nombre'] . ' ' . $row['apellido'].'</td>
            <td>'.$row['dni'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['celular'].'</td>
            <td><span class="badge badge-'.$classes.'">'.$tipoSolicitante.'</span></td>
            <td>'.$row['fechaRecojo'].'</td>
            <td>'.$row['fechaDevolucion'].'</td>
            <td>
              <form class="formAjax" method="POST" data-form="update" action="'.SERVERURL.'ajax/libraryAjax.php">
                <input type="hidden" name="id-solicitud-libro" value="'.MainModel::encryption($row['idSolicitudLibro']).'" />
                <input type="hidden" name="id-libro" value="'.MainModel::encryption($row['idLibro']).'" />
                <button type="submit" class="btn btn-warning" '.$state.'>
                    <i class="fas fa-sync-alt"></i>
                </button>
              </form>
            </td>
          </tr>';
          
          $counter++;
        }

        $regFinal = $counter - 1;
      } else {
        if($total > 0) {
          $table .= '
              <tr class="text-center">
                <td colspan="10" class="text-center py-3">
                  <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga clic aca para recargar el listado.</a>
                </td>
              </tr>';
        } else {
          $table .= '
              <tr>
                <td colspan="10" class="text-center text-primary font-weight-bold py-4" >No hay registros en el sistema</td>
              </tr>';
        }
      }
      $table .= '
            </tbody>
          </table>
        </div>';

      if($total > 0 && $page <= $numPages) {
        $table .= '<p class="text-right">Mostrando usuarios '.$regInit.' al '.$regFinal.' de un total de '.$total.'</p>';

        $table .= MainModel::paginationTables($page, $numPages, $url, BUTTONSPAGINATOR);
      }

      return $table;
    }

    // actualizar estado del libro y de la solicitud
    public function updateState() {
      $idLibro = MainModel::decryption($_POST['id-libro']);
      $idLibro = MainModel::clearString($idLibro);

      $idSolicitudLibro = MainModel::decryption($_POST['id-solicitud-libro']);
      $idSolicitudLibro = MainModel::clearString($idSolicitudLibro);

      if($idLibro == "" || $idSolicitudLibro == "") {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Usted esta intentando hacer daño al sistema, no lo haga.", "error"));

        exit();
      }

      $updateStateBook = BookModel::updateStateBookModel(['idLibro' => $idLibro, 'estado' => 'Entregado']);
      
      $updateStateSolicitud = LibraryModel::updateStateSolicitudModel(['idSolicitudLibro' => $idSolicitudLibro, 'estado' => 'Entregado']);

      if($updateStateBook->rowCount() == 1 && $updateStateSolicitud->rowCount() == 1) {
        $message = MainModel::alertContent("recargar", "Estado Actualizado", "Ud. ha marcado esta solicitud como ENTREGADO.", "success");
      } else {
        $message = MainModel::alertContent("simple", "Algo salio mal.", "No hemos podido actualizar el estado del libro ni de la solicitud.", "error");
      }

      echo json_encode($message);
    }
  }