<?php
  if($ajaxRequest) {
    require_once "../models/BookModel.php";
  } else {
    require_once "./models/BookModel.php";
  }

  class BookController extends BookModel {
    // crear nuevo libro
    public function addBookController() {
      $titulo = MainModel::clearString($_POST['libro-titulo-reg']);
      $autor = MainModel::clearString($_POST['libro-autor-reg']);
      $serie = MainModel::clearString($_POST['libro-serie-reg']);
      $categoria = MainModel::clearString($_POST['libro-categoria-reg']);

      //comprobamos campos vacios obligatorios
      if($titulo == "" || $autor == "" || $serie == "" || $categoria == "") {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No has llenado todos los campos obligatorios.", "error"));

        exit();
      }

      // verificar integridad de los datos
      if(MainModel::verifyInfo("[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\22 ]{5,150}", $titulo)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El TITULO no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{10,100}", $autor)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "El AUTOR no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[a-zA-Z0-9$@.-]{7,100}", $serie)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "La SERIE no coincide con el formato solicitado.", "error"));

        exit();
      }

      if(MainModel::verifyInfo("[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\22]{5,15}", $categoria)) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "La CATEGORIA no coincide con el formato solicitado.", "error"));

        exit();
      }

      // verificar si existe libro por serie
      $checkSerie = MainModel::executeSimpleQuery("SELECT serie FROM libro WHERE serie = '$serie'");
      if($checkSerie->rowCount() > 0) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Esta SERIE ya ha sido registrado.", "error"));

        exit();
      }

      // datos para registrar
      $bookInfo = [
        "titulo" => $titulo,
        "autor" => $autor,
        "serie" => $serie,
        "categoria" => $categoria
      ];

      // enviamos info para registrar
      $saveBook = BookModel::addBookModel($bookInfo);

      if($saveBook->rowCount() == 1) {
        $message = MainModel::alertContent("limpiar", "Libro Registrado", "Los datos del libro han sido registrados con exito.", "success");
      } else {
        $message = MainModel::alertContent("simple", "Algo salio mal.", "No hemos podido registrar el libro.", "error");
      }

      echo json_encode($message);
    }

    // actualizamos el estado
    public function updateStateBook() {
      $idLibro = MainModel::decryption($_POST['id-libro']);
      $idLibro = MainModel::clearString($idLibro);

      if($idLibro == "") {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "Usted esta intentando hacer daño al sistema, no lo haga.", "error"));

        exit();
      }

      // comprobamos si existe la recepcion
      $checkBook = MainModel::executeSimpleQuery("SELECT idLibro, estado FROM libro WHERE idLibro = '$idLibro'");

      if($checkBook->rowCount() <= 0) {
        echo json_encode(MainModel::alertContent("simple", "Algo salio mal", "No hemos encontrado el libro en el sistema.", "error"));

        exit();
      } else {
        $row = $checkBook->fetch();
      }

      if($row['estado'] == "Reservado") {
        $state = "Entregado";
      }

      if($row['estado'] == "Entregado") {
        $state = "Disponible";
      }

      $info = [
        "idLibro" => $idLibro,
        "estado" => $state,
      ];

      $updateState = BookModel::updateStateBookModel($info);

      if($updateState->rowCount() == 1) {
        $message = MainModel::alertContent("recargar", "Estado Actualizado", "Ud. ha marcado esta solicitud como ENTREGADO.", "success");
      } else {
        $message = MainModel::alertContent("simple", "Algo salio mal.", "No hemos podido actualizar el estado del libro.", "error");
      }

      echo json_encode($message);
    }

    // paginacion de libros
    public function paginatorBooksController($page, $registers, $url, $search) {
      $page = MainModel::clearString($page);
      $registers = MainModel::clearString($registers);

      $url = MainModel::clearString($url);
      $url = SERVERURL . $url . "/";

      $search = MainModel::clearString($search);
      $table = "";

      $page = (isset($page) && $page > 0) ? (int)$page : 1;
      $start = ($page > 0) ? (($page * $registers) - $registers) : 0;

      if(isset($search) && $search != "") {
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM libro WHERE titulo LIKE '%$search%' OR autor LIKE '%$search%' OR serie LIKE '%$search%' OR categoria LIKE '%$search%' ORDER BY titulo ASC LIMIT $start, $registers";
      } else {
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM libro ORDER BY titulo ASC LIMIT $start, $registers";
      }

      $connection = MainModel::connect();

      $data = $connection->query($query);
      $data = $data->fetchAll();

      $total = $connection->query("SELECT FOUND_ROWS()");
      $total = (int)$total->fetchColumn();
      
      $numPages = ceil($total / $registers);

      $table .= '
        <div class="table-responsive">
          <table class="table table-dark table-sm">
            <thead>
              <tr class="text-center roboto-medium">
                <th>#</th>
                <th>TITULO</th>
                <th>AUTOR</th>
                <th>SERIE</th>
                <th>CATEGORIA</th>
                <th>ESTADO</th>
                <th>LIBERAR</th>
                <th>ACTUALIZAR</th>
              </tr>
            </thead>
            <tbody>';

      if($total > 0 && $page <= $numPages) {
        $counter = $start + 1;
        $regInit = $start + 1;

        foreach ($data as $row) {
          $classState = ['Disponible' => 'success', 'Reservado' => 'warning', 'Entregado' => 'dark'];

          $state = $row['estado'] != 'Entregado' ? 'disabled' : null;

          $table .= '
              <tr class="text-center">
                <td>'.$counter.'</td>
                <td>'.$row['titulo'].'</td>
                <td>'.$row['autor'].'</td>
                <td>'.$row['serie'].'</td>
                <td>'.$row['categoria'].'</td>
                <td><span class="badge badge-'.$classState[$row['estado']].'">'.$row['estado'].'</span></td>
                <td>
                  <form class="formAjax" method="POST" data-form="update" action="'.SERVERURL.'ajax/bookAjax.php">
                    <input type="hidden" name="id-libro" value="'.MainModel::encryption($row['idLibro']).'" />
                    <button type="submit" class="btn btn-warning" '.$state.'>
                        <i class="fas fa-sync-alt"></i>
                    </button>
                  </form>
                </td>
                <td>
                  <a href="'.SERVERURL.'book-update/'.MainModel::encryption($row['idLibro']).'" class="btn btn-success">
                      <i class="fa fa-edit"></i>	
                  </a>
                </td>
              </tr>';
              
          $counter++;
        }
        $regFinal = $counter - 1;
      } else {
        if($total > 0) {
          $table .= '
              <tr class="text-center">
                <td colspan="8" class="text-center py-3">
                  <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga clic aca para recargar el listado.</a>
                </td>
              </tr>';
        } else {
          $table .= '
              <tr>
                <td colspan="8" class="text-center text-primary font-weight-bold py-4" >No hay registros en el sistema</td>
              </tr>';
        }
      }
      $table .= '
            </tbody>
          </table>
        </div>';

      if($total > 0 && $page <= $numPages) {
        $table .= '<p class="text-right">Mostrando usuarios '.$regInit.' al '.$regFinal.' de un total de '.$total.'</p>';

        $table .= MainModel::paginationTables($page, $numPages, $url, BUTTONSPAGINATOR);
      }

      return $table;
    }
  }