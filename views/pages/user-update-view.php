<?php
	if($loginController->encryption($_SESSION['id']) != $urlArray[1]) {
		if($_SESSION['privilegio'] != 1) {
			echo $loginController->forceCloseSessionController();
	
			exit();
		}
	}
?>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR USUARIO
	</h3>
	<p class="text-justify">
		Seccion para el control de usuarios, aqui puede actualizar la informacion de los usuarios.
	</p>
</div>

<?php if($_SESSION['privilegio'] == 1) {?>
<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>user-new"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-list"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-search"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
		</li>
	</ul>	
</div>
<?php } ?>

<div class="container-fluid">
	<?php
		require_once "./controllers/userController.php";
		$uc = new UserController();

		$userInfo = $uc->getUserController('user', $urlArray[1]);

		if($userInfo->rowCount() == 1) {
			$row = $userInfo->fetch();
	?>
	<form action="<?php echo SERVERURL; ?>ajax/userAjax.php" data-form="update" class="form-neon formAjax" method="POST" autocomplete="off">
		<input type="hidden" name="usuario-id-up" value="<?php echo $urlArray[1] ?>">
	
		<fieldset>
			<legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="usuario_dni" class="bmd-label-floating">DNI</label>
							<input type="text" pattern="[0-9]{8}" class="form-control" name="usuario-dni-up" minlength="8" id="usuario_dni" maxlength="8" value="<?php echo $row['dni'];?>" required>
						</div>
					</div>
					
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
							<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}" class="form-control" name="usuario-nombre-up" id="usuario_nombre" minlength="3" maxlength="35" required value="<?php echo $row['nombre'];?>">
						</div>
					</div>

					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
							<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}" class="form-control" name="usuario-apellido-up" id="usuario_apellido" minlength="3" maxlength="35" required value="<?php echo $row['apellido'];?>">
						</div>
					</div>
				</div>
			</div>
		</fieldset>

		<br><br><br>

		<fieldset>
			<legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_usuario" class="bmd-label-floating">Nombre de usuario</label>
							<input type="text" pattern="[a-zA-Z0-9]{5,35}" class="form-control" name="usuario-usuario-up" id="usuario_usuario" maxlength="35" minlength="5" required value="<?php echo $row['username'];?>">
						</div>
					</div>

					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_email" class="bmd-label-floating">Email</label>
							<input type="email" class="form-control" name="usuario-email-up" id="usuario_email" maxlength="70" value="<?php echo $row['email'];?>">
						</div>
					</div>

					<?php if($_SESSION['privilegio'] == "1" && $row['idUsuario'] != 1) { ?>
					<div class="col-12">
						<div class="form-group">
							<span>Estado del Usuario &nbsp; <?php if($row['estado'] == "Activo") { echo '<span class="badge badge-info">Activo</span>'; } else { echo '<span class="badge badge-danger">Desabilitado</span>'; } ?></span>
							<select class="form-control" name="usuario-estado-up" required>
								<option value="Activo" <?php if($row['estado'] == "Activo") {echo 'selected';} ?>>Activo</option>
								<option value="Deshabilitado" <?php if($row['estado'] == "Desabilitado") {echo 'selected';} ?>>Deshabilitado</option>
							</select>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</fieldset>

		<br><br><br>

		<fieldset>
			<legend style="margin-top: 40px;"><i class="fas fa-lock"></i> &nbsp; Nueva contraseña</legend>
			<p>Para actualizar la contraseña de esta cuenta ingrese una nueva y vuelva a escribirla. En caso que no desee actualizarla debe dejar vacíos los dos campos de las contraseñas.</p>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_clave_nueva_1" class="bmd-label-floating">Contraseña</label>
							<input type="password" class="form-control" name="usuario-clave-nueva-1" id="usuario_clave_nueva_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
						</div>
					</div>

					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_clave_nueva_2" class="bmd-label-floating">Repetir contraseña</label>
							<input type="password" class="form-control" name="usuario-clave-nueva-2" id="usuario_clave_nueva_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
						</div>
					</div>
				</div>
			</div>
		</fieldset>

		<?php if($_SESSION['privilegio'] == "1" && $row['idUsuario'] != 1) { ?>
		<br><br><br>

		<fieldset>
			<legend><i class="fas fa-medal"></i> &nbsp; Nivel de privilegio</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<p><span class="badge badge-info">Administrador</span> Control total del sistema</p>
						<p><span class="badge badge-success">Secretaria</span> Solo permisos para el control de mesa de partes</p>
						<p><span class="badge badge-dark">Jefe Biblioteca</span> Solo permisos para el control de la biblioteca</p>
						<div class="form-group">
							<select class="form-control" name="usuario-privilegio-up" required>
								<option value="1" <?php if($row['privilegio'] == 1) { echo 'selected'; } ?> >
									Administrador <?php if($row['privilegio'] == 1) { echo '(Actual)'; } ?>
								</option>

								<option value="2" <?php if($row['privilegio'] == 2) { echo 'selected'; } ?> >
									Secretaria <?php if($row['privilegio'] == 2) {echo '(Actual)'; } ?>
								</option>

								<option value="3" <?php if($row['privilegio'] == 3) { echo 'selected'; } ?> >
									Jefe Biblioteca <?php if($row['privilegio'] == 3) { echo '(Actual)'; } ?>
								</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<?php } ?>

		<br><br><br>

		<fieldset>
			<p class="text-center">Para poder guardar los cambios en esta cuenta debe de ingresar su nombre de usuario y contraseña</p>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_admin" class="bmd-label-floating">Nombre de usuario</label>
							<input type="text" pattern="[a-zA-Z0-9]{5,35}" class="form-control" name="usuario-admin" id="usuario_admin" maxlength="35" required="" minlength="5" >
						</div>
					</div>

					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="clave_admin" class="bmd-label-floating">Contraseña</label>
							<input type="password" class="form-control" name="clave-admin" id="clave_admin" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" minlength="7" required="" >
						</div>
					</div>
				</div>
			</div>
		</fieldset>

		<?php if($loginController->encryption($_SESSION['id']) != $urlArray[1]) { ?>
			<input type="hidden" name="tipo-cuenta" value="impropia">
		<?php } else { ?>
				<input type="hidden" name="tipo-cuenta" value="propia">
		<?php } ?>

		<p class="text-center" style="margin-top: 40px;">
			<button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
		</p>
	</form>

	<?php } else { ?>

	<div class="alert alert-danger text-center" role="alert">
		<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
		<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
		<p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
	</div>

	<?php } ?>
</div>