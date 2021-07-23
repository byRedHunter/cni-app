<?php
	// si ingresa una persona de biblioteca
	if($_SESSION['privilegio'] == 3) {
		echo $loginController->forceCloseSessionController();

		exit();
	}
?>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR DOCUMENTO
	</h3>
	<p class="text-justify">
		En esta seccion usted puede buscar documentos, por los siguientes requerimientos: por asunto, por la fecha, por el codigo del documento, o el dni, nombre, apellido del solicitante.
		Cabe resaltar que la fecha debe de tener el siguiente formato <strong>aaaa-mm-dd</strong> es decir <strong>año-mes-dia</strong>, un ejemplo seria <strong>2021-07-05</strong>.
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>desk-recents"><i class="far fa-calendar-alt"></i> &nbsp; Recientes</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>desk-list"><i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; Todos</a>
		</li>
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>desk-search"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; BUSCAR DOCUMENTO</a>
		</li>
	</ul>
</div>

<?php
	if(!isset($_SESSION['busqueda-desk']) && empty($_SESSION['busqueda-desk'])) {
?>
<div class="container-fluid">
	<form class="form-neon formAjax" action="<?php echo SERVERURL; ?>ajax/searchAjax.php" method="POST" data-form="default" autocomplete="off">
		<input type="hidden" name="modulo" value="desk">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label for="inputSearch" class="bmd-label-floating">¿Qué documento estas buscando?</label>
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
		<input type="hidden" name="modulo" value="desk">
		<input type="hidden" name="eliminar-busqueda" value="eliminar">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<p class="text-center" style="font-size: 20px;">
						Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda-desk'] ?>”</strong>
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
		require_once "./controllers/procedureController.php";
		$pc = new ProcedureController();

		$numPage = isset($urlArray[1]) ? $urlArray[1] : 1;
		$numPage = $numPage == "" ? 1 : $numPage;
		$secPage = $urlArray[0];
		$search = '';

		switch($_SESSION['busqueda-desk']) {
			case 'solicitud':
			case 'Solicitud':
			case 'SOLICITUD':
				$search = '1';
			break;

			case 'oficio':
			case 'oficio':
			case 'oficio':
				$search = '2';
			break;

			case 'carta':
			case 'Carta':
			case 'CARTA':
				$search = '3';
			break;

			case 'memorandum':
			case 'Memorandum':
			case 'MEMORANDUM':
				$search = '4';
			break;

			case 'otro':
			case 'Otro':
			case 'OTRO':
				$search = '5';
			break;
			
			default:
				$search = $_SESSION['busqueda-desk'];
		}

		echo $pc->paginatorProceduresController($numPage, ROWSTABLE, $_SESSION["privilegio"], $secPage, "todos", $search);
	?>
</div>
<?php } ?>