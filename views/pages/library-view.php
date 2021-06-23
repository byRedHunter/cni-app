<?php
  include_once "./views/components/header-landing.php";
?>

<section class="library">
  <div class="content">
    <h2 class="form-title mb-5">Solicitar Libro</h2>

	  <form action="" class="form-landing form-neon py-5" autocomplete="off" style="overflow: hidden;">
		  <fieldset class="mb-4">
			  <legend class="mb-4 pl-4 text-blue"><i class="fas fa-user text-primary"></i> &nbsp; Información de Usuario</legend>
			  <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-tipo-usuario" class="bmd-label-floating text-top">Usuario</label>
                <select class="form-control" name="libro-tipo-usuario">
                  <option value="" selected="" disabled="">Seleccione una opción </option>
                  <option value="1">Profesor</option>
                  <option value="2">Estudiante</option>
                </select>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-dni" class="bmd-label-floating">DNI</label>
                <input type="text" pattern="[0-9-]{1,27}" class="form-control" name="libro-dni" id="libro-dni" maxlength="27">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-nombre" class="bmd-label-floating">Nombre</label>
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="libro-nombre" id="libro-nombre" maxlength="40">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-apellido" class="bmd-label-floating">Apellido</label>
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="libro-apellido" id="libro-apellido" maxlength="40">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-email" class="bmd-label-floating">Email</label>
                <input type="email" class="form-control" name="libro-email" id="libro-email" maxlength="70">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-telefono" class="bmd-label-floating">Teléfono</label>
                <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="libro-telefono" id="libro-telefono" maxlength="20">
              </div>
            </div>
          </div>
        </div>
      </fieldset>

      <fieldset class="mb-4">
			  <legend class="text-blue my-4 pl-4"><i class="fas fa-book text-primary"></i> &nbsp; Información del Libro</legend>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-libro-nombre" class="bmd-label-floating">Nombre del Libro</label>
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="libro-libro-nombre" id="libro-libro-nombre" maxlength="40">
              </div>
            </div>
          </div>
        </div>
      </fieldset>

      <fieldset>
			  <legend class="text-blue my-4 pl-4"><i class="fas fa-calendar text-primary"></i> &nbsp; Información de la Fecha</legend>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-fecha" class="bmd-label-floating text-top">Fecha de Recojo</label>
                <input type="date" name="libro-fecha-recojo" class="form-control">
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-fecha" class="bmd-label-floating text-top">Fecha de Devolución</label>
                <input type="date" name="libro-fecha-devol" class="form-control">
              </div>
            </div>
          </div>
        </div>
      </fieldset>

      <div class="text-center mt-5">
        <button type="reset" class="btn btn-raised btn-secondary btn-sm px-5"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
        &nbsp; &nbsp;
        <button type="submit" class="btn btn-raised btn-info btn-sm px-5"><i class="far fa-save"></i> &nbsp; Enviar</button>
      </div>
    </form>
  </div>
</section>

<?php
  include_once "./views/components/footer-landing.php";
?>