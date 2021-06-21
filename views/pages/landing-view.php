<?php
  include_once "./views/components/header-landing.php";
?>

<main class="slider">
  <section class="slider-item active">
    <figure class="slider-item-bg">
      <img src="<?php echo SERVERURL ?>views/assets/images/slider/slide_00.jpg" alt="Entrada del colegio CNI, imperial">
    </figure>

    <div class="slider-item-content content">
      <h1>IE. CNI Imperial</h1>
      <div class="label">Honor, gallardia y disciplina</div>
    </div>
  </section>

  <section class="slider-item">
    <figure class="slider-item-bg">
      <img src="<?php echo SERVERURL ?>views/assets/images/slider/slide_01.jpg" alt="Entrada del colegio CNI, imperial">
    </figure>

    <div class="slider-item-content content">
      <h1>Taller de Musica</h1>
    </div>
  </section>

  <section class="slider-item">
    <figure class="slider-item-bg">
      <img src="<?php echo SERVERURL ?>views/assets/images/slider/slide_02.jpg" alt="Entrada del colegio CNI, imperial">
    </figure>

    <div class="slider-item-content content">
      <h1>Taller de Ajedrez</h1>
      <div class="label">Ejercita el cerebro.</div>
    </div>
  </section>

  <section class="slider-item">
    <figure class="slider-item-bg">
      <img src="<?php echo SERVERURL ?>views/assets/images/slider/slide_03.jpg" alt="Entrada del colegio CNI, imperial">
    </figure>

    <div class="slider-item-content content">
      <h1>Gloriosa Banda de Música</h1>
    </div>
  </section>

  <section class="slider-item">
    <figure class="slider-item-bg">
      <img src="<?php echo SERVERURL ?>views/assets/images/slider/slide_04.jpg" alt="Entrada del colegio CNI, imperial">
    </figure>

    <div class="slider-item-content content">
      <h1>Banda de Músicos</h1>
      <div class="label">más de 60 alumnos</div>
    </div>
  </section>

  <section class="slider-item">
    <figure class="slider-item-bg">
      <img src="<?php echo SERVERURL ?>views/assets/images/slider/slide_05.jpg" alt="Entrada del colegio CNI, imperial">
    </figure>

    <div class="slider-item-content content">
      <h1>Más de 180 promociones egresadas</h1>
    </div>
  </section>

  <section class="slider-item">
    <figure class="slider-item-bg">
      <img src="<?php echo SERVERURL ?>views/assets/images/slider/slide_06.png" alt="Imponente estadio y pista atlética">
    </figure>

    <div class="slider-item-content content">
      <h1>Imponente estadio y pista atlética</h1>
    </div>
  </section>

  <section class="slider-control">
    <div class="slider-control-item active"></div>
    <div class="slider-control-item"></div>
    <div class="slider-control-item"></div>
    <div class="slider-control-item"></div>
    <div class="slider-control-item"></div>
    <div class="slider-control-item"></div>
    <div class="slider-control-item"></div>
  </section>
</main>

<section class="about" id="about">
  <div class="content">
    <h2>Quiénes Somos</h2>

    <div class="about-content">
      <figure>
        <img src="<?php echo SERVERURL ?>views/assets/images/about.jpg" alt="Profesores del CNI">
      </figure>

      <div class="text">
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Exercitationem, dolorem?</p>

        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eaque rem molestiae vero, sed distinctio sunt explicabo laboriosam facere cupiditate id debitis placeat. Sapiente ea beatae aut consequuntur ipsum? Pariatur, mollitia. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas mollitia optio provident fugiat id laudantium rem ratione iusto, facilis beatae sapiente ad ex doloremque quam exercitationem necessitatibus consequuntur minus dolores.</p>

        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eaque rem molestiae vero, sed distinctio sunt explicabo laboriosam facere cupiditate id debitis placeat. Sapiente ea beatae aut consequuntur ipsum? Pariatur, mollitia.</p>
      </div>
    </div>
  </div>
</section>

<section class="video-responsive">
  <iframe width="100%" height="100%" src="https://www.youtube.com/embed/uTyUflDOXQA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</section>

<section class="gallery" id="gallery">
  <div class="content">
    <h2>Galeria</h2>

    <div class="gallery-content">
      <figure>
        <img src="<?php echo SERVERURL; ?>views/assets/images/gallery/computo.jpg" alt="">
        <figcaption>
          Aula de Computación
        </figcaption>
      </figure>

      <figure>
        <img src="<?php echo SERVERURL; ?>views/assets/images/gallery/marcha.jpg" alt="">
        <figcaption>
          Fiestas Patrias
        </figcaption>
      </figure>

      <figure>
        <img src="<?php echo SERVERURL; ?>views/assets/images/gallery/clases.jpg" alt="">
        <figcaption>
          Salón de Clases
        </figcaption>
      </figure>

      <figure>
        <img src="<?php echo SERVERURL; ?>views/assets/images/gallery/ajedrez.jpg" alt="">
        <figcaption>
          Taller de Ajedrez
        </figcaption>
      </figure>

      <figure>
        <img src="<?php echo SERVERURL; ?>views/assets/images/gallery/ciclismo.jpg" alt="">
        <figcaption>
          Deportes - Ciclismo
        </figcaption>
      </figure>

      <figure>
        <img src="<?php echo SERVERURL; ?>views/assets/images/gallery/banda.jpg" alt="">
        <figcaption>
          Banda Institucional
        </figcaption>
      </figure>

      <figure>
        <img src="<?php echo SERVERURL; ?>views/assets/images/gallery/estadio.jpg" alt="">
        <figcaption>
          Estadio CNI
        </figcaption>
      </figure>

      <figure>
        <img src="<?php echo SERVERURL; ?>views/assets/images/gallery/danzas.jpg" alt="">
        <figcaption>
          Danzas
        </figcaption>
      </figure>

      <figure>
        <img src="<?php echo SERVERURL; ?>views/assets/images/gallery/lozas.jpg" alt="">
        <figcaption>
          Deportes - Lozas CNI
        </figcaption>
      </figure>
    </div>
  </div>
</section>

<?php
  include_once "./views/components/footer-landing.php";
?>