<?php
  include_once "./views/components/header-landing.php";
?>

<section class="library">
  <div class="content">
    <h2 class="form-title mb-5">Mesa de Partes</h2>

	  <form class="form-landing form-neon py-5 formAjax" method="POST" action="<?php echo SERVERURL; ?>ajax/procedureAjax.php" data-form="save" enctype="multipart/form-data" autocomplete="off" style="overflow: hidden;">
		  <fieldset class="mb-4">
			  <legend class="text-dark mb-3 pl-4"><i class="fas fa-user"></i> &nbsp; Información personal</legend>
			  <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud-dni" class="bmd-label-floating">DNI *</label>
                <input type="text" pattern="[0-9]{8}" class="form-control" name="solicitud-dni" id="solicitud-dni" maxlength="8" minlength="8" required>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud-nombre" class="bmd-label-floating">Nombre *</label>
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" class="form-control" name="solicitud-nombre" id="solicitud-nombre" maxlength="40" minlength="3" required>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud-apellido" class="bmd-label-floating">Apellido *</label>
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,40}" class="form-control" name="solicitud-apellido" id="solicitud-apellido" maxlength="40" minlength="5" required>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud-email" class="bmd-label-floating">Email *</label>
                <input type="email" class="form-control" name="solicitud-email" id="solicitud-email" maxlength="70">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud-celular" class="bmd-label-floating">Celular *</label>
                <input type="text" pattern="[0-9]{9}" class="form-control" name="solicitud-celular" id="solicitud-celular" maxlength="9" minlength="9" required>
              </div>
            </div>
          </div>
        </div>
      </fieldset>

      <fieldset class="mb-4">
			  <legend class="text-dark mb-3 pl-4"><i class="fas fa-file"></i> &nbsp; Información del documento</legend>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud-tipo-documento" class="bmd-label-floating text-top">Tipo de documento *</label>
                <select class="form-control" name="solicitud-tipo-documento" required>
                  <option value="0" selected="" disabled>Seleccione una opción </option>
                  <option value="1">Solicitud</option>
                  <option value="2">Oficio</option>
                  <option value="3">Carta</option>
                  <option value="4">memorandum</option>
                  <option value="5">Otro</option>
                </select>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="solicitud-nombre" class="bmd-label-floating">Asunto *</label>
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,40}" class="form-control" name="solicitud-asunto" id="solicitud-asunto" maxlength="40" minlength="5" required>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="mesa-file" class="bmd-label-floating">Archivo (sodo .pdf) *</label>
                <input type="file" name="solicitud-file[]">
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