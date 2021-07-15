<?php
  if($ajaxRequest) {
    require_once "../models/ProcedureModel.php";
  } else {
    require_once "./models/ProcedureModel.php";
  }

  class ProcedureController extends ProcedureModel {
    // crear nueva recepcion
    public function addProcedureController() {
      $dni = MainModel::clearString($_POST['solicitud-dni']);
      $nombre = MainModel::clearString($_POST['solicitud-nombre']);
      $apellido = MainModel::clearString($_POST['solicitud-apellido']);
      $email = MainModel::clearString($_POST['solicitud-email']);
      $celular = MainModel::clearString($_POST['solicitud-celular']);

      $asunto = MainModel::clearString($_POST['solicitud-asunto']);
      $tipoDocumento = isset($_POST['solicitud-tipo-documento']) ? MainModel::clearString($_POST['solicitud-tipo-documento']) : "0";
      $archivo = $_FILES['solicitud-file'];

      // comprobamos campos vacios obligatorios
      if($dni == "" || $nombre == "" || $apellido == "" || $email == "" || $celular == "" || $asunto == "" || $tipoDocumento == "0" || count($archivo) < 0) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No has completado todos los campos obligatorios.", "error"));

        exit();
      }

      // verificar integridad de los datos
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

      if( $tipoDocumento < 1 || $tipoDocumento > 5) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El PRIVILEGIO seleccionado no es válido.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,40}", $asunto)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El ASUNTO no coincide con el formato solicitado.", "error"));

        exit();
      }

      // validar que el archivo solo sea .pdf
      if(pathinfo($archivo['name'][0], PATHINFO_EXTENSION) != "pdf") {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El ARCHIVO no coincide con el formato solicitado, recuerda que solo acepta archivos pdf.", "error"));

        exit();
      }

      // datos a registrar
      $idSolicitante = 0;
      $solicitanteInfo = [
        "dni" => $dni,
        "nombre" => $nombre,
        "apellido" => $apellido,
        "email" => $email,
        "celular" => $celular
      ];
      
      // vemos si ya existe el solicitante
      $existSolicitante = SolicitanteModel::getSolicitanteModel(['dni' => $dni]);
      if($existSolicitante->rowCount() > 0) {
        $row = $existSolicitante->fetch();

        // comparamos si los datos son iguales
        if($nombre == $row['nombre'] && $apellido == $row['apellido'] && $email == $row['email'] && $celular == $row['celular']) {
          // son iguales, guardamos idSolicitante
          $idSolicitante = $row['idSolicitante'];
        } else {
          // actualizamos datos
          SolicitanteModel::updateSolicitanteModel($solicitanteInfo);
          $idSolicitante = $row['idSolicitante'];
        }
      } else {
        // si no eixte solicitante, registramos
        $solRes = SolicitanteModel::addSolicitanteModel($solicitanteInfo);
        if($solRes['query']->rowCount() == 1) {
          $idSolicitante = $solRes['id'];
        }
      }

      // obtenemos la ruta del archivo
      $fileContent = file_get_contents($archivo['tmp_name'][0]);
      $nameFile = uniqid();
      $routeFile = "../views/assets/pdf/" . $nameFile . "." . pathinfo($archivo['name'][0], PATHINFO_EXTENSION);

      // guardamos el archivo en la carpeta pdf
      if(file_put_contents($routeFile, $fileContent)) {
        // registrar la recepcion
        $recepcionInfo = [
          'asunto' => $asunto,
          'tipoDocumento' => $tipoDocumento,
          'archivo' => $nameFile . ".pdf",
          'idSolicitante' => $idSolicitante,
          'codigo' => MainModel::codeToRegister(),
        ];

        $saveRecepcion = ProcedureModel::addProcedureModel($recepcionInfo);

        if($saveRecepcion->rowCount() == 1) {
          $message = MainModel::alertContent("limpiar", "Solicitud Registrada", "¡IMPORTANTE! Su codigo de solicitud es " . $recepcionInfo['codigo'] . " guardelo.", "success");
        } else {
          $message = MainModel::alertContent("simple", "Algo salio mal.", "No hemos podido registrar sus datos, intentelo más tarde.", "error");
        }
  
        echo json_encode($message);
      } else {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Hubo un problema con tu archivo.", "error"));

        exit();
      }
    }

    // obtener informacion del solicitante
    public function getInfoSolicitante() {
      $data = SolicitanteModel::getSolicitanteModel(['dni' => $_POST['solicitud-dni']]);

      if($data->rowCount() == 1) {
        $row = $data->fetch();

        $message = [
          'error' => false,
          'name' => $row['nombre'],
          'lastName' => $row['apellido'],
          'email' => $row['email'],
          'phone' => $row['celular']
        ];
      } else {
        $message = [
          'error' => true,
          'message' => 'No existe ese usuario'
        ];
      }

      echo json_encode($message);
    }

    // obtener datos totales de la solicitud
    public function getTotalProcedures() {
      $query = MainModel::connect()->prepare("SELECT idRecepcion FROM recepcion");

      $query->execute();

      return $query;
    }

    // paginacion de solicitudes
    public function paginatorProceduresController($page, $registers, $privilegio, $url, $type, $search) {
      $page = MainModel::clearString($page);
      $registers = MainModel::clearString($registers);

      $type = MainModel::clearString($type);

      $url = MainModel::clearString($url);
      $url = SERVERURL . $url . "/";

      $search = MainModel::clearString($search);
      $table = "";

      $page = (isset($page) && $page > 0) ? (int)$page : 1;
      $start = ($page > 0) ? (($page * $registers) - $registers) : 0;

      // si hay termino de busqueda
      if(isset($search) && $search != "") {
        // hay un termino
        $query = "SELECT SQL_CALC_FOUND_ROWS s.nombre, s.apellido, s.email, s.celular, r.asunto, r.tipoDocumento, r.idRecepcion, r.fecha, r.estado, r.archivo FROM recepcion as r INNER JOIN solicitante as s ON r.idSolicitante = s.idSolicitante WHERE r.asunto LIKE '%$search%' OR r.fecha LIKE '%$search%' ORDER BY r.fecha DESC LIMIT $start, $registers";
      } else {
        // que tipo de busqueda es
        if($type == "recientes") {
          // recientes
          $query = "SELECT SQL_CALC_FOUND_ROWS s.nombre, s.apellido, s.email, s.celular, r.idRecepcion, r.asunto, r.tipoDocumento, r.fecha, r.estado, r.archivo FROM recepcion as r INNER JOIN solicitante as s ON r.idSolicitante = s.idSolicitante WHERE r.fecha <= NOW() AND r.fecha >= date_add(NOW(), INTERVAL -1 DAY) ORDER BY r.fecha DESC LIMIT $start, $registers";
        } else {
          // todos
          $query = "SELECT SQL_CALC_FOUND_ROWS s.nombre, s.apellido, s.email, s.celular, r.idRecepcion, r.asunto, r.tipoDocumento, r.fecha, r.estado, r.archivo FROM recepcion as r INNER JOIN solicitante as s ON r.idSolicitante = s.idSolicitante ORDER BY r.fecha DESC LIMIT $start, $registers";
        }
      }

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
                <th>ASUNTO</th>
                <th>TIPO</th>
                <th>FECHA</th>
                <th>SOLICITANTE</th>
                <th>EMAIL</th>
                <th>CELULAR</th>
                <th>ESTADO</th>
                <th>DOCUMENTO</th>
                <th>RESPONDIDO</th>
              </tr>
            </thead>
            <tbody>';
      
      if($total > 0 && $page <= $numPages) {
        $counter = $start + 1;
        $regInit = $start + 1;

        $regFinal = $counter - 1;

        foreach ($data as $row) {
          $tipoDocumento = DOCUMENTOS[$row['tipoDocumento']];
          $classes = CLASES[$row['tipoDocumento']];
          $classState = ['Nuevo' => 'success', 'Respondido' => 'warning'];

          $table .= '
          <tr class="text-center" >
            <td>'.$counter.'</td>
            <td>'.$row['asunto'].'</td>
            <td><span class="badge badge-'.$classes.'">'.$tipoDocumento.'</span></td>
            <td>'.$row['fecha'].'</td>
            <td>'.$row['nombre'] . ' ' . $row['apellido'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['celular'].'</td>
            <td><span class="badge badge-'.$classState[$row['estado']].'">'.$row['estado'].'</span></td>
            <td>
              <a href="'.SERVERURL.'views/assets/pdf/'.$row['archivo'].'" class="btn btn-info" target="_blank">
                  <i class="fas fa-file-pdf"></i>	
              </a>
            </td>
            <td>
              <form class="formAjax" method="POST" data-form="update" action="'.SERVERURL.'ajax/procedureAjax.php">
                <input type="hidden" name="id-recepcion" value="'.MainModel::encryption($row['idRecepcion']).'" />
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-sync-alt"></i>
                </button>
              </form>
            </td>
          </tr>';
          
          $counter++;
        }
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
  }