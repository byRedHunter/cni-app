<?php
  require_once "MainModel.php";

  class LoginModel extends MainModel {
    // iniciar sesion
    protected static function initSessionModel($data) {
      $query = MainModel::connect()->prepare("SELECT * FROM usuario WHERE username = :username AND clave = :clave AND estado = 'Activo'");

      $query->bindParam(":username", $data["usuario"]);
      $query->bindParam(":clave", $data["clave"]);

      $query->execute();

      return $query;
    }
  }