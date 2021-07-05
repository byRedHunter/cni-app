<?php
  require_once "SolicitanteModel.php";

  class ProcedureModel extends SolicitanteModel {
    // agregar solicitud a la DB
    protected static function addProcedureModel($datos) {
      $query = MainModel::connect()->prepare("INSERT INTO recepcion(asunto, tipoDocumento, archivo, idSolicitante) VALUES (:asunto, :tipoDocumento, :archivo, :idSolicitante)");

      $query->bindParam(":asunto", $datos['asunto']);
      $query->bindParam(":tipoDocumento", $datos['tipoDocumento']);
      $query->bindParam(":archivo", $datos['archivo']);
      $query->bindParam(":idSolicitante", $datos['idSolicitante']);

      $query->execute();

      return $query;
    }
  }