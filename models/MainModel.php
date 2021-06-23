<?php
  if($ajaxRequest) {
    require_once "../config/server.php";
  } else {
    require_once "./config/server.php";
  }

  class MainModel {
    protected static function connect() {
      $connection = new PDO(SGDB, USER, PASSWORD);
      $connection->exec("SET CHARACTER SET utf8");

      return $connection;
    }

    protected static function executeSimpleQuery($query) {
      $sql = self::connect()->prepare($query);
      $sql->execute();

      return $sql;
    }

    protected static function alertContent($alert = "simple", $title = "Algo salió mal.", $text, $type = "error") {
      $alertJson = [
        "alert" => $alert,
        "title" => $title,
        "text" => $text,
        "type" => $type
      ];

      return $alertJson;
    }

    /* encriptar cadenas */
    protected static function encryption($string){
			$output = false;
			$key = hash('sha256', SECRET_KEY);
			$iv = substr(hash('sha256', SECRET_IV), 0, 16);
			$output = openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output = base64_encode($output);

			return $output;
		}

    /* desencriptar cadenas */
		protected static function decryption($string){
			$key = hash('sha256', SECRET_KEY);
			$iv = substr(hash('sha256', SECRET_IV), 0, 16);
			$output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);

			return $output;
		}

    // generar codigos aleatorios
    protected static function generateRandomCode($word, $length, $number) {
      for ($i = 1; $i <= $length; $i++) {
        $random = rand(0, 9);
        $word .= $random;
      }

      return $word . "-" . $number;
    }

    protected static function clearString($string) {
      $string = trim($string);
      $string = stripslashes($string);
      $string = str_ireplace("<script>", "", $string);
      $string = str_ireplace("</script>", "", $string);
      $string = str_ireplace("<script src>", "", $string);
      $string = str_ireplace("<script type=>", "", $string);
      $string = str_ireplace("SELECT * FROM", "", $string);
      $string = str_ireplace("DELETE FROM", "", $string);
      $string = str_ireplace("INSERT INTO", "", $string);
      $string = str_ireplace("DROP TABLE", "", $string);
      $string = str_ireplace("DROP DATABASE", "", $string);
      $string = str_ireplace("TRUNCATE TABLE", "", $string);
      $string = str_ireplace("SHOW TABLES", "", $string);
      $string = str_ireplace("SHOW DATABASES", "", $string);
      $string = str_ireplace("<?php", "", $string);
      $string = str_ireplace("?>", "", $string);
      $string = str_ireplace("--", "", $string);
      $string = str_ireplace(">", "", $string);
      $string = str_ireplace("<", "", $string);
      $string = str_ireplace("[", "", $string);
      $string = str_ireplace("]", "", $string);
      $string = str_ireplace("^", "", $string);
      $string = str_ireplace("==", "", $string);
      $string = str_ireplace(";", "", $string);
      $string = str_ireplace("::", "", $string);
      $string = stripslashes($string);
      $string = trim($string);

      return $string;
    }

    // verificar datos
    protected static function verifyInfo($filter, $string) {
      if(preg_match("/^" . $filter . "$/", $string)) {
        return false;
      }

      return true;
    }

    // verificar fechas
    protected static function verifyDate($date) {
      $values = explode('-', $date);

      if(count($values) == 3 && checkdate($values[1], $values[2], $values[0])) {
        return false;
      }

      return true;
    }

    // paginador de tablas
    protected static function paginationTables($page, $numPages, $url, $buttons) {
      $pagination = '<nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">';

      if($page == 1) {
        $table .= '<li class="page-item disabled"><a class="page-link"><i class="fa fa-angle-double-left"></i></a></li>';
      } else {
        $table .= '<li class="page-item"><a class="page-link" href="'.$url.'1/"><i class="fa fa-angle-double-left"></i></a></li>
        <li class="page-item"><a class="page-link" href="'.$url.($page - 1).'/">Anterior</a></li>';
      }

      $countIterations = 0;
      for($i = $page; $i <= $numPages; $i++) {
        if($countIterations >= $buttons) {
          break;
        }

        if($page == $i) {
          $pagination .= '<li class="page-item"><a class="page-link active" href="'.$url.$i.'/">'.$i.'</a></li>';
        } else {
          $pagination .= '<li class="page-item"><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>';
        }

        $countIterations++;
      }

      if($page == $numPages) {
        $table .= '<li class="page-item disabled"><a class="page-link"><i class="fa fa-angle-double-right"></i></a></li>';
      } else {
        $table .= '<li class="page-item"><a class="page-link" href="'.$url.($page + 1).'/">Siguiente</a></li>
        <li class="page-item"><a class="page-link" href="'.$url.$numPages.'/"><i class="fa fa-angle-double-right"></i></a></li>';
      }

      $pagination .= '</ul></nav>';

      return $pagination;
    }
  }