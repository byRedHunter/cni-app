<?php
	// si ingresa una persona de biblioteca
	if($_SESSION['privilegio'] == 3) {
		echo $loginController->forceCloseSessionController();

		exit();
	}
?>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; TODOS LOS DOCUMENTOS
	</h3>
	<p class="text-justify">
		En esta seccion se listaran todos los documentos registrados en el sistema, ahora cuando Ud. haya respondido la solictud debe de marcarlo como <strong>"Respondido"</strong> en la columna de <strong>"RESPONDIDO"</strong>.
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>desk-recents"><i class="far fa-calendar-alt"></i> &nbsp; Recientes</a>
		</li>
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>desk-list"><i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; Todos</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>desk-search"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; BUSCAR DOCUMENTO</a>
		</li>
	</ul>
</div>

<div class="container-fluid">
	<?php
		require_once "./controllers/procedureController.php";
		$pc = new ProcedureController();

		$numPage = isset($urlArray[1]) ? $urlArray[1] : 1;
		$numPage = $numPage == "" ? 1 : $numPage;
		$secPage = $urlArray[0];

		echo $pc->paginatorProceduresController($numPage, ROWSTABLE, $_SESSION["privilegio"], $secPage, "todos", "");
	?>
</div>