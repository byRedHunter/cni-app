<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo COLEGIO ?></title>
  <link rel="shortcut icon" href="<?php echo SERVERURL; ?>views/assets/images/logo.png" type="image/x-icon">

  <?php
    include_once "./views/components/styles.php";
  ?>
</head>
<body>
  <?php
    $ajaxRequest = false;
    require_once "./controllers/ViewController.php";
    $viewController = new ViewController();
    $page = $viewController->getViewController();

    if($page == "404" || $page =="login" || $page =="library" || $page =="procedure") {
      require_once "./views/pages/" . $page . "-view.php";
    } else {
      session_start(["name" => NAMESESSION]);

      $urlArray = explode("/", $_GET['view']);

      require_once "./controllers/loginController.php";
      $loginController = new LoginController();

      if(!isset($_SESSION["token"]) || !isset($_SESSION["username"]) || !isset($_SESSION["privilegio"]) || !isset($_SESSION["id"])) {
        echo $loginController->forceCloseSessionController();

        exit();
      }
  ?>

  <div class="dashboard">
    <main class="main-container">
      <?php
        include "./views/components/sidebar.php";
      ?>

      <section class="full-box page-content">
        <?php
          include_once "./views/components/navbar.php";
          include $page;
        ?>
      </section>
    </main>
  </div>

  <?php
      include "./views/components/logout.php";
    }

    include_once "./views/components/scripts.php";
  ?>
</body>
</html>