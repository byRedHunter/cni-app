<?php
  if($ajaxRequest) {
    require_once "../models/LoginModel.php";
  } else {
    require_once "./models/LoginModel.php";
  }

  class LoginController extends LoginModel {
    // iniciar sesion
    public function initSessionController() {
      $username = MainModel::clearString($_POST["usuario-login"]);
      $password = MainModel::clearString($_POST["clave-login"]);

      // comporbar campos obligatorios
      if($username == "" || $password == "") {
        echo MainModel::alertText("No ha llenado los campos que son requeridos");

        exit();
      }

      // verificar integridad de los datos
      if(MainModel::verifyInfo("[a-zA-Z0-9]{5,35}", $username)) {
        echo MainModel::alertText("El NOMBRE DE USUARIO no coincide con el formato solicitado.");

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-Z0-9$@.-]{7,100}", $password)) {
        echo MainModel::alertText("La CLAVE no coincide con el formato solicitado.");

        exit();
      }

      $password = MainModel::encryption($password);

      $loginData = [
        "usuario" => $username,
        "clave" => $password
      ];

      $request = LoginModel::initSessionModel($loginData);

      if($request->rowCount() == 1) {
        $row = $request->fetch();

        session_start(["name" => "cni"]);

        $_SESSION["id"] = $row["idUsuario"];
        $_SESSION["nombre"] = $row["nombre"];
        $_SESSION["apellido"] = $row["apellido"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["privilegio"] = $row["privilegio"];
        $_SESSION["token"] = md5(uniqid(mt_rand(), true));

        return header("Location: " . SERVERURL . "home");
      } else {
        echo MainModel::alertText("Los datos ingresados son incorrectos.");

        exit();
      }
    }

    // forzar cierre de sesion
    public function forceCloseSessionController() {
      session_unset();
      session_destroy();

      if(headers_sent()) {
        return "
          <script>
            window.location.href = '".SERVERURL."login';
          </script>
        ";
      } else {
        return header("Location: " . SERVERURL . "login");
      }
    }

    // cerrar session
    public function closeSessionController() {
      session_start(["name" => "cni"]);

      $token = MainModel::decryption($_POST['token']);
      $usuario = MainModel::decryption($_POST['username']);

      if($token == $_SESSION['token'] && $usuario == $_SESSION['username']) {
        session_unset();
        session_destroy();

        $alert = [
          "alert" => "redireccionar",
          "url" => SERVERURL . "login"
        ];
      } else {
        $alert = MainModel::alertContent("simple", "Algo salio mal.", "No se pudo cerrar la sesion en el sistema.", "error");
      }

      echo json_encode($alert);
    }
  }
