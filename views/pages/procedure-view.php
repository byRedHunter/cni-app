<?php
  include_once "./views/components/header-landing.php";
?>

<section class="library">
  <div class="content">
    <h2 class="form-title mb-5">Mesa de Partes</h2>

	  <form action="" class="form-landing form-neon py-5" autocomplete="off" style="overflow: hidden;">
		  <fieldset>
			  <legend class="text-dark mb-5 pl-4"><i class="fas fa-file"></i> &nbsp; Información de solicitud</legend>
			  <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud-dni" class="bmd-label-floating">DNI</label>
                <input type="text" pattern="[0-9-]{1,27}" class="form-control" name="solicitud-dni" id="solicitud-dni" maxlength="27">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud-nombre" class="bmd-label-floating">Nombre</label>
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="solicitud-nombre" id="solicitud-nombre" maxlength="40">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud_apellido" class="bmd-label-floating">Apellido</label>
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="solicitud_apellido" id="solicitud_apellido" maxlength="40">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud-email" class="bmd-label-floating">Email</label>
                <input type="email" class="form-control" name="solicitud-email" id="solicitud-email" maxlength="70">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud-telefono" class="bmd-label-floating">Teléfono</label>
                <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="solicitud-telefono" id="solicitud-telefono" maxlength="20">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="mesa-file" class="bmd-label-floating">Archivo (sodo .pdf)</label>
                <input type="file" required name="solicitud-file">
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