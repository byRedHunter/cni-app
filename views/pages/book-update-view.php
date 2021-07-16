<?php
	// si ingresa una persona de desk
	if($_SESSION['privilegio'] == 2) {
		echo $loginController->forceCloseSessionController();

		exit();
	}
?>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-book fa-fw"></i> &nbsp; ACTULIZAR DATOS DEL LIBRO
	</h3>

    <p class="text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium quod harum vitae, fugit quo soluta. Molestias officiis voluptatum delectus doloribus at tempore, iste optio quam recusandae numquam non inventore dolor.
    </p>
</div>

<?php if($_SESSION['privilegio'] != 2) {?>
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
			<a href="<?php echo SERVERURL; ?>book-search"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR LIBRO</a>
		</li>
    </ul>
</div>
<?php } ?>

<div class="container-fluid">
	<?php
		require_once "./controllers/bookController.php";
		$bc = new BookController();

		$bookInfo = $bc->getBooksController($urlArray[1]);

		if($bookInfo->rowCount() == 1) {
			$row = $bookInfo->fetch();
	?>
	<div class="container-fluid form-neon">
		<form action="<?php echo SERVERURL; ?>ajax/bookAjax.php" data-form="update" class="form-neon formAjax" method="POST" autocomplete="off">
		    <input type="hidden" name="libro-id-up" value="<?php echo $urlArray[1] ?>">
            <fieldset class="mb-4">
                <legend><i class="fas fa-book"></i> &nbsp; Datos del libro</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="libro-titulo" class="bmd-label-floating">Titulo <small> (*)</small></label>
                                <input type="text" pattern="[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\22 ]{5,50}" class="form-control" name="libro-titulo-act" id="libro-titulo" minlength="5" maxlength="50" required value="<?php echo $row['titulo'];?>">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
						    <div class="form-group">
							    <label for="libro-serie" class="bmd-label-floating">Serie <small> (*)</small></label>
							    <input type="text" class="form-control" name="libro-serie-act" id="libro-serie" pattern="[a-zA-Z0-9$@.-]{7,100}" minlength="7" maxlength="100" required="" value="<?php echo $row['serie'];?>">
						    </div>
					    </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group bmd-form-group is-filled">
                                <label for="libro-categoria" class="bmd-label-floating">Categoria <small> (*)</small></label>
                                <input type="text" pattern="[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\22]{5,15}" class="form-control" name="libro-categoria-act" id="libro-categoria" minlength="5" maxlength="50" required value="<?php echo $row['categoria'];?>">
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
                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}" class="form-control" name="libro-autor-act" id="libro-autor" maxlength="35" required value="<?php echo $row['autor'];?>">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <br><br><br>

            <fieldset>
			    <p class="text-center font-weight-bold">Para poder guardar los cambios de este libro usted debe de ingresar su nombre de usuario y contraseña</p>
			    <div class="container-fluid">
				    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="usuario_admin" class="bmd-label-floating">Nombre de usuario</label>
                                <input type="text" pattern="[a-zA-Z0-9]{5,35}" class="form-control" name="usuario-admin" id="usuario_admin" maxlength="35" required="" minlength="5" >
                            </div>
                        </div>

					    <div class="col-12 col-md-6">
						    <div class="form-group">
							    <label for="clave_admin" class="bmd-label-floating">Contraseña</label>
							    <input type="password" class="form-control" name="clave-admin" id="clave_admin" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" minlength="7" required="" >
						    </div>
					    </div>
				    </div>
			    </div>
		    </fieldset>
            
			<br><br>

			<p class="text-center" style="margin-top: 40px;">
				<button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
			</p>
		</form>
    </div>
    <?php } else { ?>

    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>

    <?php } ?>
</div>