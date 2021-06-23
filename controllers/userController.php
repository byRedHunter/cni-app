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
  }