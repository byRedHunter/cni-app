<?php
	// si ingresa una persona de desk
	if($_SESSION['privilegio'] == 2) {
		echo $loginController->forceCloseSessionController();

		exit();
	}
?>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-book fa-fw"></i> &nbsp; Buscar LIBRO
	</h3>

  <p class="text-justify">
    Puede buscar los libros por autor, titulo, serie, categoria y estado del libro.
  </p>
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>book-reservation"><i class="far fa-calendar-alt"></i> &nbsp; RESERVACIONES</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>book-new"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO LIBRO</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>book-list"><i class="fas fa-list fa-fw"></i> &nbsp; LISTA LIBROS</a>
		</li>
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>book-search"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR LIBRO</a>
		</li>
  </ul>
</div>

<?php
	if(!isset($_SESSION['busqueda-book']) && empty($_SESSION['busqueda-book'])) {
?>
<div class="container-fluid">
	<form class="form-neon formAjax" action="<?php echo SERVERURL; ?>ajax/searchAjax.php" method="POST" data-form="default" autocomplete="off">
		<input type="hidden" name="modulo" value="book">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<div class="form-group bmd-form-group">
						<label for="inputSearch" class="bmd-label-floating">¿Qué libro estas buscando?</label>
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
		<input type="hidden" name="modulo" value="book">
		<input type="hidden" name="eliminar-busqueda" value="eliminar">
		<div class="row justify-content-md-center">
			<div class="col-12 col-md-6">
				<p class="text-center" style="font-size: 20px;">
					Resultados de la busqueda <strong>“Buscar”</strong>
				</p>
			</div>
			<div class="col-12">
				<p class="text-center" style="margin-top: 20px;">
					<button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
				</p>
			</div>
		</div>
	</form>
</div>

<div class="container-fluid">
	<?php
		require_once "./controllers/bookController.php";
		$bc = new BookController();

		$numPage = isset($urlArray[1]) ? $urlArray[1] : 1;
		$numPage = $numPage == "" ? 1 : $numPage;
		$secPage = $urlArray[0];

		echo $bc->paginatorBooksController($numPage, ROWSTABLE, $secPage, $_SESSION['busqueda-book']);
	?>
</div>
<?php } ?>