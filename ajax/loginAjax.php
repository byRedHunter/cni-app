<?php
  $ajaxRequest = true;
  require_once "../config/app.php";

  if(isset($_POST['token']) && isset($_POST['username'])) {
    require_once "../controllers/loginController.php";
    $lc = new LoginController();

    echo $lc->closeSessionController();
  } else {
    session_start(["name" => "cni"]);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login");
    exit();
  }