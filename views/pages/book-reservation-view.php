<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-book fa-fw"></i> &nbsp; RESERVACION DE LIBRO
	</h3>

  <p class="text-justify">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium quod harum vitae, fugit quo soluta. Molestias officiis voluptatum delectus doloribus at tempore, iste optio quam recusandae numquam non inventore dolor.
  </p>
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>book-reservation"><i class="far fa-calendar-alt"></i> &nbsp; RESERVACIONES</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>book-new"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO LIBRO</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>book-list"><i class="fas fa-list fa-fw"></i> &nbsp; LISTA LIBROS</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>book-search"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR POR TITULO</a>
		</li>
  </ul>
</div>

 <div class="container-fluid">
	<div class="table-responsive">
		<table class="table table-dark table-sm">
			<thead>
				<tr class="text-center roboto-medium">
					<th>#</th>
					<th><span class="text-table">asdfgasd</span>TITULO<span class="text-table">asdfgasd</span></th>
					<th>CATEGORIA</th>
					<th>ESTADO</th>
					<th>SOLICITANTE</th>
					<th>DNI</th>
					<th>NOMBRE</th>
					<th>EMAIL</th>
					<th>CELULAR</th>
					<th>FECHA RECOJO</th>
					<th>FECHA DEVOL.</th>
					<th>ACTUALIZAR</th>
					<th>ELIMINAR</th>
				</tr>
			</thead>
			<tbody>
				<tr class="text-center" >
					<td>1</td>
					<td style="">Aunque tenga miedo hágalo igual</td>
					<td><span class="badge badge-dark">Otro</span></td>
					<td><span class="badge badge-success">Libre</span></td>
					<td><span class="badge badge-primary">Estudiante</span></td>
					<td>45201225</td>
					<td>Martin Gutierrez</td>
					<td>martin.gutierrez@gmail.com</td>
					<td>964587858</td>
					<td>25-06-2021</td>
					<td>30-06-2021</td>
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
					<td>2</td>
					<td>Aunque tenga miedo hágalo igual</td>
					<td><span class="badge badge-info">Secundaria</span></td>
					<td><span class="badge badge-success">Libre</span></td>
					<td><span class="badge badge-primary">Estudiante</span></td>
					<td>45201225</td>
					<td>Martin Gutierrez</td>
					<td>martin.gutierrez@gmail.com</td>
					<td>964587858</td>
					<td>25-06-2021</td>
					<td>30-06-2021</td>
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
					<td>3</td>
					<td>Aunque tenga miedo hágalo igual</td>
					<td><span class="badge badge-success">Primaria</span></td>
					<td><span class="badge badge-success">Libre</span></td>
					<td><span class="badge badge-info">Profesor</span></td>
					<td>45201225</td>
					<td>Martin Gutierrez</td>
					<td>martin.gutierrez@gmail.com</td>
					<td>964587858</td>
					<td>25-06-2021</td>
					<td>30-06-2021</td>
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