<?php
	// si ingresa una persona de desk
	if($_SESSION['privilegio'] == 2) {
		echo $loginController->forceCloseSessionController();

		exit();
	}
?>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-book fa-fw"></i> &nbsp; LISTA DE LIBROS
	</h3>

  <p class="text-justify">
    En esta seccion visualizara las lista de todos los libros registrados en el sistema.
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
			<a class="active" href="<?php echo SERVERURL; ?>book-list"><i class="fas fa-list fa-fw"></i> &nbsp; LISTA LIBROS</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>book-search"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR LIBRO</a>
		</li>
  </ul>
</div>

 <div class="container-fluid">
	<?php
		require_once "./controllers/bookController.php";
		$bc = new BookController();

		$numPage = isset($urlArray[1]) ? $urlArray[1] : 1;
		$numPage = $numPage == "" ? 1 : $numPage;
		$secPage = $urlArray[0];

		echo $bc->paginatorBooksController($numPage, ROWSTABLE, $secPage, "");
	?>
</div>