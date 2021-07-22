<?php
	if($_SESSION['privilegio'] != 1) {
		echo $loginController->forceCloseSessionController();

		exit();
	}
?>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-user fa-fw"></i> &nbsp; NUEVO USUARIO
	</h3>
	<p class="text-justify">
		Seccion para el control de usuarios, aqui puede registrar nuevos usuariarios teniendo en cuenta los privilegios que este tendra.
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>user-new"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-list"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-search"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
		</li>
	</ul>	
</div>

<div class="container-fluid">
	<form class="form-neon formAjax" method="POST" action="<?php echo SERVERURL; ?>ajax/userAjax.php" data-form="save" autocomplete="off">
		<fieldset>
			<legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="usuario-dni" class="bmd-label-floating">DNI <small>*</small></label>
							<input type="text" pattern="[0-9]{8}" class="form-control" name="usuario-dni-reg" id="usuario-dni" maxlength="20" required>
						</div>
					</div>
					
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="usuario-nombre" class="bmd-label-floating">Nombres <small> *</small></label>
							<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}" class="form-control" name="usuario-nombre-reg" id="usuario-nombre" minlength="3" maxlength="35" required>
						</div>
					</div>

					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="usuario-apellido" class="bmd-label-floating">Apellidos <small> *</small></label>
							<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}" class="form-control" name="usuario-apellido-reg" id="usuario-apellido" minlength="3" maxlength="35" required>
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
							<label for="usuario-usuario" class="bmd-label-floating">Nombre de usuario <small> *</small></label>
							<input type="text" pattern="[a-zA-Z0-9]{5,35}" class="form-control" name="usuario-username-reg" id="usuario-usuario" maxlength="35" minlength="5" required>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario-email" class="bmd-label-floating">Email</label>
							<input type="email" class="form-control" name="usuario-email-reg" id="usuario-email" maxlength="70">
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario-clave-1" class="bmd-label-floating">Contraseña <small> *</small></label>
							<input type="password" class="form-control" name="usuario-clave-1-reg" id="usuario-clave-1" pattern="[a-zA-Z0-9$@.-]{7,100}"  minlength="7" maxlength="100" required="" >
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario-clave-2" class="bmd-label-floating">Repetir contraseña <small> *</small></label>
							<input type="password" class="form-control" name="usuario-clave-2-reg" id="usuario-clave-2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" minlength="7" required="" >
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<br><br><br>
		<fieldset>
			<legend><i class="fas fa-medal"></i> &nbsp; Nivel de privilegio <small> *</small></legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<p><span class="badge badge-info">Administrador</span> Control total del sistema</p>
						<p><span class="badge badge-success">Secretaria</span> Solo permisos para el control de mesa de partes</p>
						<p><span class="badge badge-dark">Biblioteca</span> Solo permisos para el control de la biblioteca</p>
						<div class="form-group">
							<select class="form-control" name="usuario-privilegio" required>
								<option value="" selected="" disabled="">Seleccione una opción</option>
								<option value="1">Administrador</option>
								<option value="2">Secretaria</option>
								<option value="3">Jefe Biblioteca</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<p class="text-center" style="margin-top: 40px;">
			<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
			&nbsp; &nbsp;
			<button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
		</p>
	</form>
</div>