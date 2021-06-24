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
			<a href="<?php echo SERVERURL; ?>book-search"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR POR TITULO</a>
		</li>
    </ul>
</div>

<div class="container-fluid">
	<div class="container-fluid form-neon">
		<form action="" autocomplete="off" method="POST">
            <fieldset class="mb-4">
                <legend><i class="fas fa-book"></i> &nbsp; Datos del libro</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="libro-titulo" class="bmd-label-floating">Titulo <small> (*)</small></label>
                                <input type="text" pattern="[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\22 ]{5,50}" class="form-control" name="libro-titulo-reg" id="libro-titulo" minlength="5" maxlength="50" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
						    <div class="form-group">
							    <label for="libro-serie" class="bmd-label-floating">Serie <small> (*)</small></label>
							    <input type="password" class="form-control" name="libro-serie-reg" id="libro-serie" pattern="[a-zA-Z0-9$@.-]{7,100}" minlength="7" maxlength="100" required="" >
						    </div>
					    </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group bmd-form-group is-filled">
                                <label for="libro-categoria" class="bmd-label-floating text-top">Categoria<small> (*)</small></label>
                                <select class="form-control" name="libro-categoria-reg" id="libro-categoria" required>
                                    <option value="" selected="" disabled="">Seleccione una opción</option>
                                    <option value="1">Primaria</option>
                                    <option value="2">Secundaria</option>
                                    <option value="3">Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group bmd-form-group is-filled">
                                <label for="libro-estado" class="bmd-label-floating text-top">Estado<small> (*)</small></label>
                                <select class="form-control" name="libro-categoria-act" id="libro-estado" required>
                                    <option value="" selected="" disabled="">Seleccione una opción</option>
                                    <option value="1">Libre</option>
                                    <option value="2">Prestado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend><i class="fas fa-history"></i> &nbsp; Datos del autor</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="libro-autor" class="bmd-label-floating">Autor <small> (*)</small></label>
                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}" class="form-control" name="libro-autor-reg" id="libro-autor" maxlength="35" required>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            
			<br><br>
			<p class="text-center" style="margin-top: 40px;">
				<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
				&nbsp; &nbsp;
				<button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
			</p>
		</form>
	</div>