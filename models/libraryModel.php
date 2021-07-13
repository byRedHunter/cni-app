<?php
  require_once "BookModel.php";

  class LibraryModel extends BookModel {
    protected static function addSolicitudLibro($datos) {
      $query = MainModel::connect()->prepare("INSERT INTO solicitud_libro(tipoSolicitante, fechaRecojo, fechaDevolucion, idSolicitante, idLibro, codigo) VALUES (:tipoSolicitante, :fechaRecojo, :fechaDevolucion, :idSolicitante, :idLibro, :codigo)");

      $query->bindParam(":tipoSolicitante", $datos['tipoSolicitante']);
      $query->bindParam(":fechaRecojo", $datos['fechaRecojo']);
      $query->bindParam(":fechaDevolucion", $datos['fechaDevolucion']);
      $query->bindParam(":idSolicitante", $datos['idSolicitante']);
      $query->bindParam(":idLibro", $datos['idLibro']);
      $query->bindParam(":codigo", $datos['codigo']);

      $query->execute();

      return $query;
    }
  }