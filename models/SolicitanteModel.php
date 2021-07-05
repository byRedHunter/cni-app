<?php
  require_once "MainModel.php";

  class SolicitanteModel extends MainModel {
    // agregar solicitante a la DB
    protected static function addSolicitanteModel($datos) {
      $pdo = MainModel::connect();
      $query = $pdo->prepare("INSERT INTO solicitante(dni, nombre, apellido, email, celular) VALUES(:dni, :nombre, :apellido, :email, :celular)");

      $query->bindParam(":dni", $datos['dni']);
      $query->bindParam(":nombre", $datos['nombre']);
      $query->bindParam(":apellido", $datos['apellido']);
      $query->bindParam(":email", $datos['email']);
      $query->bindParam(":celular", $datos['celular']);

      $query->execute();
      $lastId = $pdo->lastInsertId();

      return ['query' => $query, 'id' => $lastId];
    }

    // obtener datos de un solicitante
    protected static function getSolicitanteModel($datos) {
      $query = MainModel::connect()->prepare("SELECT * FROM solicitante WHERE dni = :dni");

      $query->bindParam(":dni", $datos['dni']);
      
      $query->execute();

      return $query;
    }

    // actualizar datos del solicitante
    protected static function updateSolicitanteModel($datos) {
      $query = MainModel::connect()->prepare("UPDATE solicitante SET nombre = :nombre, apellido = :apellido, email = :email, celular = :celular WHERE dni = :dni");

      $query->bindParam("nombre", $datos['nombre']);
      $query->bindParam("apellido", $datos['apellido']);
      $query->bindParam("email", $datos['email']);
      $query->bindParam("celular", $datos['celular']);
      $query->bindParam("dni", $datos['dni']);

      $query->execute();

      return $query;
    }
  }