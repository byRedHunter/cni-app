<?php
  require_once "MainModel.php";

  class BookModel extends MainModel {
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
  }