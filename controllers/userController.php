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
    }
  }