<?php
  include_once "./views/components/header-landing.php";
?>

<section class="library">
  <div class="content">
    <h2 class="form-title mb-5">Solicitar Libro</h2>

	  <form action="<?php echo SERVERURL; ?>ajax/libraryAjax.php" data-form="save" method="POST" class="form-landing form-neon py-5 formAjax" autocomplete="off" style="overflow: hidden;">
      <fieldset class="mb-4">
        <legend class="text-blue my-4 pl-4"><i class="fas fa-book text-primary"></i> &nbsp; Información del Libro</legend>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-libro-nombre" class="bmd-label-floating">Nombre del Libro</label>
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control book-name" name="libro-libro-nombre" id="libro-libro-nombre" maxlength="40">
              </div>
            </div>
            <div class="col-12 col-md-6 d-flex align-items-center">
              <button class="btn btn-raised btn-success search-books" type="button"><i class="fa fa-search"></i> Buscar Libro</button>
            </div>
          </div>

          <div class="row books-container d-none">
            <div class="col-12">
              <h5 class="mensaje-busqueda mt-4">Seleccione su lirbo</h5>
            </div>

            <div class="list-books col-12 d-flex flex-wrap" style="gap: 10px">
              <!-- cargamos dinamicamente la lista de libros -->
            </div>
          </div>
        </div>
      </fieldset>

		  <fieldset class="mb-4">
			  <legend class="mb-4 pl-4 text-blue"><i class="fas fa-user text-primary"></i> &nbsp; Información de Usuario</legend>
			  <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-tipo-usuario" class="bmd-label-floating text-top">Usuario</label>
                <select class="form-control" name="libro-tipo-usuario">
                  <option value="0" selected="" disabled="">Seleccione una opción </option>
                  <option value="1">Profesor</option>
                  <option value="2">Estudiante</option>
                </select>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-dni" class="bmd-label-floating">DNI</label>
                <input type="text" pattern="[0-9]{8}" class="form-control" name="libro-dni" id="libro-dni" maxlength="8" minlength="8" required>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-nombre" class="bmd-label-floating">Nombre</label>
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,40}" class="form-control" name="libro-nombre" id="libro-nombre" maxlength="40" minlength="5" required>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="libro-apellido" class="bmd-label-floating">Apellido</label>
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,40}" class="form-control" name="libro-apellido" id="libro-apellido" maxlength="40" minlength="5" required>
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
                <label for="libro-celular" class="bmd-label-floating">Celular</label>
                <input type="text" pattern="[0-9]{9}" class="form-control" name="libro-celular" id="libro-celular" maxlength="9" minlength="9" required>
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

<script>
  const $searchBooks = document.querySelector('.search-books')
  const $nameBook = document.querySelector('.book-name')

  const getBooks = (nameBook) => {
    let data = new FormData()
    data.append('get', 'books')
    data.append('name-book', nameBook)

    const url = '<?php echo SERVERURL; ?>ajax/libraryAjax.php';

    fetch(url, {
      method: 'POST',
      body: data,
    })
    .then(response => response.json())
    .then(info => {
      console.log(info);
      let template = ''
      const $booksList = document.querySelector('.list-books')
      const $booksContainer = document.querySelector('.books-container')
      const $mensaje = document.querySelector('.mensaje-busqueda')

      $booksList.innerHTML = ''

      $booksContainer.classList.remove('d-none')
      $booksContainer.classList.add('d-flex')
      $mensaje.innerText = info.message

      if(!info.error) {
        const books = info.data

        books.forEach(book => {
          template += `
            <div class="form-check">
              <input required type="radio" class="form-check-input" name="libro-id-libro" value="${book.idLibro}" id="libro-id-${book.idLibro}">
              
              <label for="libro-id-${book.idLibro}" class="form-check-label">${book.titulo} <strong>${book.autor}</strong></label>
            </div>
          `
        })

        $booksList.innerHTML = template
      }
    })
  }

  $searchBooks.addEventListener('click', (e) => {
    if($nameBook.value === '') return

    getBooks($nameBook.value)
  })
</script>