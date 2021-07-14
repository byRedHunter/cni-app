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
                    <button type="submit" class="btn btn-warning">
                        <i class="far fa-trash-alt"></i>
                    </button>
                  </form>
                </td>
              </tr>';
              
          $counter++;
        }
      } else {
        if($total > 0) {
          $table .= '
              <tr class="text-center" >
                <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm d-block mx-auto mb-4">Haga clic aca para recargar el listado.</a>
              </tr>';
        } else {
          $table .= '
              <tr class="text-center" >
                <td>No hay registros en el sistema</td>
              </tr>';
        }
      }
      $table .= '
            </tbody>
          </table>
        </div>';

      if($total > 0 && $page <= $numPages) {
        $table .= MainModel::paginationTables($page, $numPages, $url, BUTTONSPAGINATOR);
      }

      return $table;
    }
  }