<?php
  $ajaxRequest = true;
  require_once "../config/app.php";

  if(isset($_POST['solicitud-dni']) || isset($_POST['id-recepcion'])) {
    require_once "../controllers/procedureController.php";
    $pc = new ProcedureController();

    // traemos los datos del solicitante
    if(isset($_POST['solicitud-dni']) && isset($_POST['action'])) {
      echo $pc->getInfoSolicitante();
    }

    // registramos nueva solicitud
    if(isset($_POST['solicitud-dni']) && isset($_POST['solicitud-asunto']) && isset($_FILES['solicitud-file'])) {
      echo $pc->addProcedureController();
    }

    // actualizamos el estado de la solicitud de nuevo a respondido
    if(isset($_POST['id-recepcion'])) {
      echo $pc->updateStateProcedure();
    }
  } else {
    session_start(["name" => NAMESESSION]);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login");
    exit();
  }