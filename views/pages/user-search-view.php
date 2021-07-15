<?php
	if($_SESSION['privilegio'] != 1) {
		echo $loginController->forceCloseSessionController();

		exit();
	}
?>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO
	</h3>
	<p class="text-justify">
		Seccion para el control de usuarios, aqui puede buscar a uno o varios usuarios dependiendo de la coincidencia generada por el texto ingresado.
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>user-new"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-list"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
		</li>
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>user-search"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
		</li>
	</ul>	
</div>

<?php
	if(!isset($_SESSION['busqueda-user']) && empty($_SESSION['busqueda-user'])) {
?>
<div class="container-fluid">
	<form class="form-neon formAjax" action="<?php echo SERVERURL; ?>ajax/searchAjax.php" method="POST" data-form="default" autocomplete="off">
		<input type="hidden" name="modulo" value="user">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label for="inputSearch" class="bmd-label-floating">¿Qué usuario estas buscando?</label>
						<input type="text" class="form-control" name="busqueda-inicial" id="inputSearch" maxlength="30">
					</div>
				</div>
				<div class="col-12">
					<p class="text-center" style="margin-top: 40px;">
						<button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
					</p>
				</div>
			</div>
		</div>
	</form>
</div>
<?php } else { ?>
<div class="container-fluid">
	<form class="formAjax" action="<?php echo SERVERURL; ?>ajax/searchAjax.php" method="POST" data-form="search" autocomplete="off">
		<input type="hidden" name="modulo" value="user">
		<input type="hidden" name="eliminar-busqueda" value="eliminar">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<p class="text-center" style="font-size: 20px;">
						Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda-user'] ?>”</strong>
					</p>
				</div>
				<div class="col-12">
					<p class="text-center" style="margin-top: 20px;">
						<button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
					</p>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="container-fluid">
	<?php
		require_once "./controllers/userController.php";
		$uc = new UserController();

		$numPage = isset($urlArray[1]) ? $urlArray[1] : 1;
		$numPage = $numPage == "" ? 1 : $numPage;
		$secPage = $urlArray[0];

		echo $uc->paginatorUserController($numPage, ROWSTABLE, $_SESSION["privilegio"], $_SESSION["id"], $secPage, $_SESSION['busqueda-user']);
	?>
</div>
<?php } ?>
