<?php
	session_start(["name" => "cni"]);

  if(isset($_SESSION["token"]) || isset($_SESSION["username"]) || isset($_SESSION["privilegio"]) || isset($_SESSION["id"])) {
    header("Location: " . SERVERURL . "home");
    exit();
  }
?>

<div class="login-container">
  <div class="login-content">
    <p class="text-center">
      <img src="<?php echo SERVERURL; ?>views/assets/images/logo.png" alt="Insignia CNI - Imperial" class="login-logo">
    </p>
    <p class="text-center">
      Inicia sesión con tu cuenta
    </p>
    <form method="POST" autocomplete="off" >
      <div class="form-group">
        <label for="UserName" class="bmd-label-floating"><i class="fas fa-user-secret"></i> &nbsp; Usuario</label>
        <input type="text" class="form-control" id="UserName" name="usuario-login" pattern="[a-zA-Z0-9]{5,35}" minlength="5" maxlength="35" required="" >
      </div>
      <div class="form-group">
        <label for="UserPassword" class="bmd-label-floating"><i class="fas fa-key"></i> &nbsp; Contraseña</label>
        <input type="password" class="form-control" id="UserPassword" name="clave-login" pattern="[a-zA-Z0-9$@.-]{7,100}" minlength="7" maxlength="100" required="" autocomplete="true" >
      </div>
      <button type="submit" class="btn-login text-center">LOG IN</button>
    </form>
  </div>
</div>

<?php
  if(isset($_POST['usuario-login']) && isset($_POST['clave-login'])) {
    require_once "./controllers/loginController.php";
    $login = new LoginController();

    echo $login->initSessionController();
  }
?>