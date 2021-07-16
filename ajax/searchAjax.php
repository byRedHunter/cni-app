<?php
  require_once "../config/app.php";
  session_start(["name" => NAMESESSION]);

  if (isset($_POST['busqueda-inicial']) || isset($_POST['eliminar-busqueda']) || isset($_POST['fecha-inicio']) || isset($_POST['fecha-final'])) {
    $dataUrl = [
      "user" => 'user-search',
      "desk" => 'desk-search',
      "book" => 'book-search',
    ];

    if(isset($_POST['modulo'])) {
      $modulo = $_POST['modulo'];

      if(!isset($dataUrl[$modulo])) {
        $alert = [
          "alert" => 'simple',
          "title" => 'Algo salio mal',
          "text" => 'No podemos continuar con la busqueda debido a un error.',
          "type" => 'error',
        ];
  
        echo json_encode($alert);
        exit();
      }
    } else {
      $alert = [
        "alert" => 'simple',
        "title" => 'Algo salio mal',
        "text" => 'No podemos continuar con la busqueda debido a un error de configuración.',
        "type" => 'error',
      ];

      echo json_encode($alert);
      exit();
    }

    if($modulo == "moduloConFecha") {
      $dateInit = "fecha-inicio-" . $modulo;
      $dateFinal = "fecha-final-" . $modulo;

      // iniciar busqueda
      if(isset($_POST['fecha-inicio']) || isset($_POST['fecha-final'])) {
        if($_POST['fecha-inicio'] == "" || $_POST['fecha-final'] == "") {
          $alert = [
            "alert" => 'simple',
            "title" => 'Algo salio mal',
            "text" => 'Por favor ingrese una fecha de inico y una fecha final para poder buscar.',
            "type" => 'error',
          ];
    
          echo json_encode($alert);
          exit();
        }

        $_SESSION[$dateInit] = $_POST['fecha-inicio'];
        $_SESSION[$dateFinal] = $_POST['fecha-final'];
      }

      // eliminar busqueda
      if(isset($_POST['eliminar-busqueda'])) {
        unset($_SESSION[$dateInit]);
        unset($_SESSION[$dateFinal]);
      }
    } else {
      $nameSearch = "busqueda-" . $modulo;

      // iniciar busqueda
      if(isset($_POST['busqueda-inicial'])) {
        if($_POST['busqueda-inicial'] == "") {
          $alert = [
            "alert" => 'simple',
            "title" => 'Algo salio mal',
            "text" => 'Por favor ingrese un término de busqueda para poder realizar la operación.',
            "type" => 'error',
          ];
    
          echo json_encode($alert);
          exit();
        }

        $_SESSION[$nameSearch] = $_POST['busqueda-inicial'];
      }

      // eliminar busqueda
      if(isset($_POST['eliminar-busqueda'])) {
        unset($_SESSION[$nameSearch]);
      }
    }

    // redireccionar
    $url = $dataUrl[$modulo];

    $alert = [
      "alert" => 'redireccionar',
      "url" => SERVERURL . $url ."/",
    ];

    echo json_encode($alert);
  } else {
    session_start(["name" => NAMESESSION]);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login");
    exit();
  }