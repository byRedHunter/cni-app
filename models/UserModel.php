<?php
  require_once "MainModel.php";

  class UserModel extends MainModel {
    // agregar usuario a la DB
    protected static function addUserModel($datos) {
      $query = MainModel::connect()->prepare("INSERT INTO usuario(dni, nombre, apellido, username, email, clave, privilegio, estado) VALUES (:dni, :nombre, :apellido, :username, :email, :clave, :privilegio, :estado)");

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

    // eliminar usuario
    protected static function deleteUserModel($idUsuario) {
      $query = MainModel::connect()->prepare("DELETE FROM usuario WHERE idUsuario = :idUsuario");
      $query->bindParam(":idUsuario", $idUsuario);

      $query->execute();

      return $query;
    }

    // obtener datos del usuario
    protected static function getUserModel($type, $idUsuario) {
      if($type == "user") {
        $query = MainModel::connect()->prepare("SELECT * FROM usuario WHERE idUsuario = :idUsuario");
        $query->bindParam(":idUsuario", $idUsuario);
      } else if($type == "count") {
        $query = MainModel::connect()->prepare("SELECT idUsuario FROM usuario WHERE idUsuario != '1'");
      }

      $query->execute();

      return $query;
    }

    // update user
    protected static function updateUserModel($datos) {
      $query = MainModel::connect()->prepare("UPDATE usuario SET dni = :dni, nombre = :nombre, apellido = :apellido, username = :username, email = :email, clave = :clave, privilegio = :privilegio, estado = :estado WHERE idUsuario = :idUsuario");

      $query->bindParam(":dni", $datos['dni']);
      $query->bindParam(":nombre", $datos['nombre']);
      $query->bindParam(":apellido", $datos['apellido']);
      $query->bindParam(":username", $datos['username']);
      $query->bindParam(":email", $datos['email']);
      $query->bindParam(":clave", $datos['clave']);
      $query->bindParam(":privilegio", $datos['privilegio']);
      $query->bindParam(":estado", $datos['estado']);
      $query->bindParam(":idUsuario", $datos['idUsuario']);

      $query->execute();

      return $query;
    }
  }