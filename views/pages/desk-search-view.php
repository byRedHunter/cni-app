<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR DOCUMENTO POR FECHA
	</h3>
	<p class="text-justify">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia fugiat est ducimus inventore, repellendus deserunt cum aliquam dignissimos, consequuntur molestiae perferendis quae, impedit doloribus harum necessitatibus magnam voluptatem voluptatum alias!
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
			<a class="active" href="<?php echo SERVERURL; ?>desk-search"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; BUSCAR POR FECHA</a>
		</li>
	</ul>
</div>

<div class="container-fluid">
	<form class="form-neon" action="">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-4">
					<div class="form-group">
						<label for="busqueda_inicio_prestamo" >Fecha inicial (día/mes/año)</label>
						<input type="date" class="form-control" name="busqueda_inicio_prestamo" id="busqueda_inicio_prestamo" maxlength="30">
					</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="form-group">
						<label for="busqueda_final_prestamo" >Fecha final (día/mes/año)</label>
						<input type="date" class="form-control" name="busqueda_final_prestamo" id="busqueda_final_prestamo" maxlength="30">
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
		<input type="hidden" name="eliminar_busqueda_prestamo" value="eliminar">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<p class="text-center" style="font-size: 20px;">
						Fecha de busqueda: <strong>01/01/2020 &nbsp; a &nbsp; 01/01/2020</strong>
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
	<div class="table-responsive">
		<table class="table table-dark table-sm">
			<thead>
				<tr class="text-center roboto-medium">
					<th>#</th>
					<th><span class="text-table">asdfgfsdf</span>ASUNTO<span class="text-table">asdfgfsdf</span></th>
					<th>TIPO</th>
					<th>FECHA</th>
					<th><span class="text-table">asdfgfsdf</span>SOLICITANTE<span class="text-table">asdfgfsdf</span></th>
					<th>EMAIL</th>
					<th>CELULAR</th>
					<th>ESTADO</th> <!-- NUEVO - RESPODIDO -->
					<th>DOCUMENTO</th>
					<th>RESPONDIDO</th>
				</tr>
			</thead>
			<tbody>
				<tr class="text-center" >
					<td>1</td>
					<td>Constancia de Estudios</td>
					<td>Solicitud</td>
					<td>30/06/2021</td>
					<td>Mario Guerra Fernandez</td>
					<td>mario.guerra@gmail.com</td>
					<td>965485785</td>
					<td><span class="badge badge-primary">Nuevo</span></td>
					<td>
						<a href="#" class="btn btn-info">
								<i class="fas fa-file-pdf"></i>	
						</a>
					</td>
					<td>
						<form action="">
							<button type="button" class="btn btn-warning">
									<i class="fas fa-sync-alt"></i>
							</button>
						</form>
					</td>
				</tr>
				<tr class="text-center" >
					<td>2</td>
					<td>Constancia de Estudios</td>
					<td>Solicitud</td>
					<td>30/06/2021</td>
					<td>Mario Guerra Fernandez</td>
					<td>mario.guerra@gmail.com</td>
					<td>965485785</td>
					<td><span class="badge badge-info">Respondido</span></td>
					<td>
						<a href="#" class="btn btn-info">
								<i class="fas fa-file-pdf"></i>	
						</a>
					</td>
					<td>
						<form action="">
							<button type="button" class="btn btn-warning" disabled>
									<i class="fas fa-sync-alt"></i>
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