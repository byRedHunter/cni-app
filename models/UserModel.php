<?php
  require_once "MainModel.php";

  class UserModel extends MainModel {
    // agregar usuario a la DB
    protected static function addUserModel($datos) {
      $query = MainModel::connect()->prepare("INSERT INTO user(dni, nombre, apellido, username, email, clave, privilegio, estado) VALUES (:dni, :nombre, :apellido, :username, :email, :clave, :privilegio, :estado)");

      $query->bindParam(":dni", $datos['dni']);
      $query->bindParam(":nombre", $datos['nombre']);
      $query->bindParam(":apellido", $datos['apellido']);
      $query->bindParam(":username", $datos['username']);
      $query->bindParam(":email", $datos['email']);
      $query->bindParam(":clave", $datos['clave']);
      $query->bindParam(":privilegio", $datos['privilegio']);
      $query->bindParam(":estado", $datos['estado']);

      $query->execute();

      return $query;
    }
  }