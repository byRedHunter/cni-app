<?php
  require_once "SolicitanteModel.php";

  class ProcedureModel extends SolicitanteModel {
    // agregar solicitud a la DB
    protected static function addProcedureModel($datos) {
      $query = MainModel::connect()->prepare("INSERT INTO recepcion(asunto, tipoDocumento, archivo, idSolicitante, codigo) VALUES (:asunto, :tipoDocumento, :archivo, :idSolicitante, :codigo)");

      $query->bindParam(":asunto", $datos['asunto']);
      $query->bindParam(":tipoDocumento", $datos['tipoDocumento']);
      $query->bindParam(":archivo", $datos['archivo']);
      $query->bindParam(":idSolicitante", $datos['idSolicitante']);
      $query->bindParam(":codigo", $datos['codigo']);

      $query->execute();

      return $query;
    }

    // editar estado del documento
    protected static function updateStateProcedureModel($idRecepcion) {
      $query = MainModel::connect()->prepare("UPDATE recepcion SET estado = 'Respondido' WHERE idRecepcion = :idRecepcion");

      $query->bindParam(":idRecepcion", $idRecepcion);

      $query->execute();

      return $query;
    }
  }