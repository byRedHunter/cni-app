<?php
  if($ajaxRequest) {
    require_once "../models/UserModel.php";
  } else {
    require_once "./models/UserModel.php";
  }

  class UserController extends UserModel {
    // crear nuevo usuario
    public function addUserController() {
      $dni = MainModel::clearString($_POST['usuario-dni-reg']);
      $nombre = MainModel::clearString($_POST['usuario-nombre-reg']);
      $apellido = MainModel::clearString($_POST['usuario-apellido-reg']);

      $username = MainModel::clearString($_POST['usuario-username-reg']);
      $email = MainModel::clearString($_POST['usuario-email-reg']);
      $clave1 = MainModel::clearString($_POST['usuario-clave-1-reg']);
      $clave2 = MainModel::clearString($_POST['usuario-clave-2-reg']);

      $privilegio = MainModel::clearString($_POST['usuario-privilegio']);

      // comprobamos campos vacios obligatorios
      if($dni == "" || $nombre == "" || $apellido == "" || $username == "" || $clave1 == "" || $clave2 == "") {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No has llenado todos los campos obligatorios.", "error"));

        exit();
      }

      // verificar integridad de los datos
      if(MainModel::verifyInfo("[0-9]{8}", $dni)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El DNI no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $nombre)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El NOMBRE no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $apellido)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El APELLIDO no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-Z0-9]{5,35}", $username)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El NOMBRE DE USUARIO no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-Z0-9$@.-]{7,100}", $clave1) || MainModel::verifyInfo("[a-zA-Z0-9$@.-]{7,100}", $clave2)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "La CLAVE no coincide con el formato solicitado.", "error"));

        exit();
      }

      // verificar si el dni ya existe
      $checkDni = MainModel::executeSimpleQuery("SELECT dni FROM usuario WHERE dni = '$dni'");
      if($checkDni->rowCount() > 0) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El DNI ingresado ya existe.", "error"));

        exit();
      }

      // verificar si existe nombre de usuario
      $checUsername = MainModel::executeSimpleQuery("SELECT username FROM usuario WHERE username = '$username'");
      if($checUsername->rowCount() > 0) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El NOMBRE DE USUARIO ingresado ya existe.", "error"));

        exit();
      }

      // verificamos que el email no exista
      if($email != "") {
        // correo valido
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $checkEmail = MainModel::executeSimpleQuery("SELECT email FROM usuario WHERE email = '$email'");
          if($checkEmail->rowCount() > 0) {
            echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El EMAIL ingresado ya existe.", "error"));
  
            exit();
          }
        } else {
          echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Ha ingresado un email invalido.", "error"));

          exit();
        }
      }

      // comprobamos que las claves sean iguales
      if($clave1 != $clave2) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Las CLAVES ingresadas, no coinciden.", "error"));

        exit();
      } else {
        $clave = MainModel::encryption($clave1);
      }

      // comprobamos el privilegio
      if($privilegio < 1 || $privilegio > 3) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El PRIVILEGIO seleccionado no es válido.", "error"));

        exit();
      }

      // datos a registrar
      $userInfo = [
        "dni" => $dni,
        "nombre" => $nombre,
        "apellido" => $apellido,
        "username" => $username,
        "email" => $email,
        "clave" => $clave,
        "privilegio" => $privilegio,
        "estado" => "Activo",
      ];

      // enviamos la informacion al modelo
      $saveUser = UserModel::addUserModel($userInfo);

      if($saveUser->rowCount() == 1) {
        $message = MainModel::alertContent("limpiar", "Usuario Registrado", "Los datos del usuario han sido registrados con exito.", "success");
      } else {
        $message = MainModel::alertContent("simple", "Algo salio mal.", "No hemos podido registrar al usuario.", "error");
      }

      echo json_encode($message);
    }

    // paginacion de usuarios
    public function paginatorUserController($page, $registers, $privilegio, $id, $url, $search) {
      $page = MainModel::clearString($page);
      $registers = MainModel::clearString($registers);
      $id = MainModel::clearString($id);

      $url = MainModel::clearString($url);
      $url = SERVERURL . $url . "/";

      $search = MainModel::clearString($search);
      $table = "";

      $page = (isset($page) && $page > 0) ? (int)$page : 1;
      $start = ($page > 0) ? (($page * $registers) - $registers) : 0;

      if(isset($search) && $search != "") {
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE ((idUsuario != '$id' AND idUsuario != '1') AND (dni LIKE '%$search%' OR nombre LIKE '%$search%' OR apellido LIKE '%$search%' OR estado LIKE '%$search%')) ORDER BY nombre ASC LIMIT $start, $registers";
      } else {
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE idUsuario != '$id' AND idUsuario != '1' ORDER BY nombre ASC LIMIT $start, $registers";
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
                <th>DNI</th>
                <th>NOMBRE</th>
                <th>USUARIO</th>
                <th>EMAIL</th>
                <th>PRIVILEGIO</th>
                <th>ACTUALIZAR</th>
                <th>ELIMINAR</th>
              </tr>
            </thead>
            <tbody>';

      if($total > 0 && $page <= $numPages) {
        $counter = $start + 1;
        $regInit = $start + 1;

        foreach ($data as $row) {
          $typeUser = PRIVILEGIOS[$row['privilegio']];
          $classUser = CLASES[$row['privilegio']];

          $table .= '
              <tr class="text-center">
                <td>'.$counter.'</td>
                <td>'.$row['dni'].'</td>
                <td>'.$row['nombre'] . ' ' . $row['apellido'].'</td>
                <td>'.$row['username'].'</td>
                <td>'.$row['email'].'</td>
                <td><span class="badge badge-'.$classUser.'">'.$typeUser.'</span></td>
                <td>
                  <a href="'.SERVERURL.'user-update/'.MainModel::encryption($row['idUsuario']).'" class="btn btn-success">
                      <i class="fas fa-sync-alt"></i>	
                  </a>
                </td>
                <td>
                  <form class="formAjax" method="POST" data-form="delete" action="'.SERVERURL.'ajax/userAjax.php">
                    <input type="hidden" name="usuario-id-del" value="'.MainModel::encryption($row['idUsuario']).'" />
                    <button type="submit" class="btn btn-warning">
                        <i class="far fa-trash-alt"></i>
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
                <td colspan="8" class="text-center py-3">
                  <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga clic aca para recargar el listado.</a>
                </td>
              </tr>';
        } else {
          $table .= '
              <tr>
                <td colspan="8" class="text-center text-primary font-weight-bold py-4" >No hay registros en el sistema</td>
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

    // eliminar usuario
    public function deleteUserController() {
      $idUsuario = MainModel::decryption($_POST['usuario-id-del']);
      $idUsuario = MainModel::clearString($idUsuario);

      if($idUsuario == 1) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No podemos eliminar al usuario principal del sistema.", "error"));

        exit();
      }

      // comprobamos al usuario en la db
      $checUser = MainModel::executeSimpleQuery("SELECT idUsuario FROM usuario WHERE idUsuario = '$idUsuario'");
      if($checUser->rowCount() <= 0) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El usuario que intenta eliminar no existe en el sistema.", "error"));

        exit();
      }

      // comprobar privilegio
      session_start(['name' => NAMESESSION]);
      if($_SESSION['privilegio'] != 1) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No tienes los permisos necesarios para realizar esta operación.", "error"));

        exit();
      }

      // eliminamos al usuario
      $deleteUser = UserModel::deleteUserModel($idUsuario);

      if($deleteUser->rowCount() == 1) {
        $message = MainModel::alertContent("recargar", "Usuario Eliminado", "El usuario ha sido eliminado del sistema con exito.", "success");
      } else {
        $message = MainModel::alertContent("simple", "Algo salio mal.", "No hemos podido eliminar al usuario, por favor intente nuevamente.", "error");
      }

      echo json_encode($message);
    }

    // obtener usuarios
    public function getUserController($type, $idUsuario) {
      $type = MainModel::clearString($type);
      $idUsuario = MainModel::decryption($idUsuario);
      $idUsuario = MainModel::clearString($idUsuario);

      return UserModel::getUserModel($type, $idUsuario);
    }

    // update user
    public function updateUserController() {
      $idUsuario = MainModel::decryption($_POST['usuario-id-up']);
      $idUsuario = MainModel::clearString($idUsuario);

      // comprobamos usuario en la DB
      $checUser = MainModel::executeSimpleQuery("SELECT * FROM usuario WHERE idUsuario = '$idUsuario'");

      if($checUser->rowCount() <= 0) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No hemos encontrado al usuario en el sistema.", "error"));

        exit();
      } else {
        $row = $checUser->fetch();
      }

      $dni = MainModel::clearString($_POST['usuario-dni-up']);
      $nombre = MainModel::clearString($_POST['usuario-nombre-up']);
      $apellido = MainModel::clearString($_POST['usuario-apellido-up']);

      $username = MainModel::clearString($_POST['usuario-usuario-up']);
      $email = MainModel::clearString($_POST['usuario-email-up']);

      $estado = isset($_POST['usuario-estado-up']) ? MainModel::clearString($_POST['usuario-estado-up']) : $row['estado'];
      $privilegio = isset($_POST['usuario-privilegio-up']) ? MainModel::clearString($_POST['usuario-privilegio-up']) : $row['privilegio'];

      $usuarioAdmin = MainModel::clearString($_POST['usuario-admin']);
      $claveAdmin = MainModel::clearString($_POST['clave-admin']);

      $tipoCuenta = MainModel::clearString($_POST['tipo-cuenta']);

      if($dni == "" || $nombre == "" || $apellido == "" || $username == "" || $usuarioAdmin == "" || $claveAdmin == "") {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No has llenado todos los campos obligatorios.", "error"));

        exit();
      }

      // verificar integridad de los datos
      if(MainModel::verifyInfo("[0-9]{8}", $dni)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El DNI no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $nombre)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El NOMBRE no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $apellido)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El APELLIDO no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-Z0-9]{5,35}", $username)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El NOMBRE DE USUARIO no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-Z0-9]{5,35}", $usuarioAdmin)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Tu NOMBRE DE USUARIO no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-Z0-9$@.-]{7,100}", $claveAdmin)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Tu CLAVE no coincide con el formato solicitado.", "error"));

        exit();
      }
      $claveAdmin = MainModel::encryption($claveAdmin);

      if($privilegio < 1 || $privilegio > 3) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El PRIVILEGIO seleccionado no es válido.", "error"));

        exit();
      }

      if($estado != "Activo" && $estado != "Desabilitado") {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El ESTADO seleccionado no es válido.", "error"));

        exit();
      }
      
      // verificar si el dni ya existe
      if($dni != $row['dni']) {
        $checkDni = MainModel::executeSimpleQuery("SELECT dni FROM usuario WHERE dni = '$dni'");
        if($checkDni->rowCount() > 0) {
          echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El DNI ingresado ya existe.", "error"));

          exit();
        }
      }

      // verificar si existe nombre de usuario
      if($username != $row['username']) {
        $checUsername = MainModel::executeSimpleQuery("SELECT username FROM usuario WHERE username = '$username'");
        if($checUsername->rowCount() > 0) {
          echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El NOMBRE DE USUARIO ingresado ya existe.", "error"));

          exit();
        }
      }

      // verificamos email
      if($email != $row['email'] && $email != "") {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $checkEmail = MainModel::executeSimpleQuery("SELECT email FROM usuario WHERE email = '$email'");
          if($checkEmail->rowCount() > 0) {
            echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El nuevo EMAIL ingresado ya existe.", "error"));

            exit();
          }
        } else {
          echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Ha ingresado un EMAIL no válido.", "error"));

          exit();
        }
      }

      // comprobar claves
      if($_POST['usuario-clave-nueva-1'] != "" || $_POST['usuario-clave-nueva-1'] != "") {
        if($_POST['usuario-clave-nueva-1'] != $_POST['usuario-clave-nueva-1']) {
          echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Las CLAVES NUEVAS no coinciden.", "error"));

          exit();
        } else {
          if(MainModel::verifyInfo("[a-zA-Z0-9$@.-]{7,100}", $_POST['usuario-clave-nueva-1']) || MainModel::verifyInfo("[a-zA-Z0-9$@.-]{7,100}", $_POST['usuario-clave-nueva-2'])) {
            echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Las CLAVES NUEVAS no coinciden con el formato solicitado.", "error"));
  
            exit();
          }

          $clave = MainModel::encryption($_POST['usuario-clave-nueva-1']);
        }
      } else {
        $clave = $row['clave'];
      }

      // comprobar credenciales para poder actualizar
      if($tipoCuenta == 'propia') {
        $checkAccount = MainModel::executeSimpleQuery("SELECT idUsuario FROM usuario WHERE username = '$usuarioAdmin' AND clave = '$claveAdmin' AND idUsuario = '$idUsuario'");
      } else {
        session_start(['name' => NAMESESSION]);
        if($_SESSION['privilegio'] != 1) {
          echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No tienes los permisos necesarios para realizar esta operacion.", "error"));

          exit();
        }

        $checkAccount = MainModel::executeSimpleQuery("SELECT idUsuario FROM usuario WHERE username = '$usuarioAdmin' AND clave = '$claveAdmin'");
      }

      if($checkAccount->rowCount() <= 0) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Nombre y clave del administrador no es valido.", "error"));

        exit();
      }

      // datos para actualizar
      $userInfo = [
        "dni" => $dni,
        "nombre" => $nombre,
        "apellido" => $apellido,
        "username" => $username,
        "email" => $email,
        "clave" => $clave,
        "privilegio" => $privilegio,
        "estado" => $estado,
        "idUsuario" => $idUsuario,
      ];
      // enviamos la informacion al modelo
      $updateUser = UserModel::updateUserModel($userInfo);

      if($updateUser->rowCount() == 1) {
        $message = MainModel::alertContent("recargar", "Usuario Actualizado", "Los datos del usuario han sido actualizados con exito.", "success");
      } else {
        $message = MainModel::alertContent("simple", "Algo salio mal.", "No hemos podido actualizar los datos del usuario.", "error");
      }

      echo json_encode($message);
    }
  }