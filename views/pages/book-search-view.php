<?php
	// si ingresa una persona de desk
	if($_SESSION['privilegio'] == 2) {
		echo $loginController->forceCloseSessionController();

		exit();
	}
?>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-book fa-fw"></i> &nbsp; NUEVO LIBRO
	</h3>

  <p class="text-justify">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium quod harum vitae, fugit quo soluta. Molestias officiis voluptatum delectus doloribus at tempore, iste optio quam recusandae numquam non inventore dolor.
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
			<a class="active" href="<?php echo SERVERURL; ?>book-search"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR POR TITULO</a>
		</li>
  </ul>
</div>

<div class="container-fluid">
<form class="form-neon" action="">
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

<div class="container-fluid">
	<form action="">
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
	<div class="table-responsive">
	<table class="table table-dark table-sm">
			<thead>
				<tr class="text-center roboto-medium">
					<th>#</th>
					<th>TITULO</th>
					<th>AUTOR</th>
					<th>SERIE</th>
					<th>CATEGORIA</th>
					<th>ESTADO</th>
					<th>ACTUALIZAR</th>
					<th>ELIMINAR</th>
				</tr>
			</thead>
			<tbody>
				<tr class="text-center" >
					<td>1</td>
					<td>Aunque tenga miedo hágalo igual</td>
					<td>Susan Jeffers</td>
					<td>1585766826587</td>
					<td><span class="badge badge-dark">Otro</span></td>
					<td><span class="badge badge-primary">Libre</span></td>
					<td>
						<a href="<?php echo SERVERURL; ?>book-update" class="btn btn-success">
							<i class="fas fa-sync-alt"></i>	
						</a>
					</td>
					<td>
						<form action="">
							<button type="button" class="btn btn-warning">
									<i class="far fa-trash-alt"></i>
							</button>
						</form>
					</td>
				</tr>
				<tr class="text-center" >
					<td>1</td>
					<td>Aunque tenga miedo hágalo igual</td>
					<td>Susan Jeffers</td>
					<td>1585766826587</td>
					<td><span class="badge badge-success">Primaria</span></td>
					<td><span class="badge badge-primary">Libre</span></td>
					<td>
						<a href="<?php echo SERVERURL; ?>book-update" class="btn btn-success">
							<i class="fas fa-sync-alt"></i>	
						</a>
					</td>
					<td>
						<form action="">
							<button type="button" class="btn btn-warning">
									<i class="far fa-trash-alt"></i>
							</button>
						</form>
					</td>
				</tr>
				<tr class="text-center" >
					<td>1</td>
					<td>Aunque tenga miedo hágalo igual</td>
					<td>Susan Jeffers</td>
					<td>1585766826587</td>
					<td><span class="badge badge-info">Secundaria</span></td>
					<td><span class="badge badge-danger">Prestado</span></td>
					<td>
						<a href="<?php echo SERVERURL; ?>book-update" class="btn btn-success">
							<i class="fas fa-sync-alt"></i>	
						</a>
					</td>
					<td>
						<form action="">
							<button type="button" class="btn btn-warning">
									<i class="far fa-trash-alt"></i>
							</button>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<nav aria-label="Page navigation example">
		<ul class="pagination justify-content-center">
			<li class="page-item disabled">
				<a class="page-link" href="#" tabindex="-1">Previous</a>
			</li>
			<li class="page-item"><a class="page-link" href="#">1</a></li>
			<li class="page-item"><a class="page-link" href="#">2</a></li>
			<li class="page-item"><a class="page-link" href="#">3</a></li>
			<li class="page-item">
				<a class="page-link" href="#">Next</a>
			</li>
		</ul>
	</nav>
</div>