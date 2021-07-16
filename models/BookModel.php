<?php
  require_once "SolicitanteModel.php";

  class BookModel extends SolicitanteModel {
    // agregar libro a la db
    protected static function addBookModel($datos) {
      $query = MainModel::connect()->prepare("INSERT INTO libro(titulo, autor, serie, categoria) VALUES (:titulo, :autor, :serie, :categoria)");

      $query->bindParam(":titulo", $datos['titulo']);
      $query->bindParam(":autor", $datos['autor']);
      $query->bindParam(":serie", $datos['serie']);
      $query->bindParam(":categoria", $datos['categoria']);

      $query->execute();

      return $query;
    }

    // obtener libros por coincidencia con el titulo
    protected static function getListBooksModel($datos) {      
      $filtro = "%" . $datos['name'] . "%";

      $query = MainModel::connect()->prepare("SELECT * FROM libro WHERE titulo LIKE :filtro AND estado = 'Disponible'");

      $query->bindParam(":filtro", $filtro);

      $query->execute();

      return $query;
    }

    // editar estado del documento
    protected static function updateStateBookModel($datos) {
      $query = MainModel::connect()->prepare("UPDATE libro SET estado = :estado WHERE idLibro = :idLibro");

      $query->bindParam(":estado", $datos['estado']);
      $query->bindParam(":idLibro", $datos['idLibro']);

      $query->execute();

      return $query;
    }
  }