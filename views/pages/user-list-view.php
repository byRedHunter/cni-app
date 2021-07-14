<?php
	if($_SESSION['privilegio'] != 1) {
		echo $loginController->forceCloseSessionController();

		exit();
	}
?>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
	</h3>
	<p class="text-justify">
		Seccion para el control de usuarios, aqui puede ver la lista de todos los usuarios que tienen acceso al sistema.
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>user-new"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
		</li>
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>user-list"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-search"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
		</li>
	</ul>	
</div>

<div class="container-fluid">
	<?php
		require_once "./controllers/userController.php";
		$uc = new UserController();

		$numPage = isset($urlArray[1]) ? $urlArray[1] : 1;
		$numPage = $numPage == "" ? 1 : $numPage;
		$secPage = $urlArray[0];

		echo $uc->paginatorUserController($numPage, ROWSTABLE, $_SESSION["privilegio"], $_SESSION["id"], $secPage, "");
	?>
</div>