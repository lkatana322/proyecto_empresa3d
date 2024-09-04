<main class="main">

  <!-- Hero Section -->
  <section id="hero" class="hero section" style="background-image: url('<?php echo base_url('assets_cliente/img/baner.png'); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 77vh; display: flex; justify-content: flex-start; align-items: center; position: relative; color: white; text-align: left; padding-left: 2rem;">
      <div class="container">
          <h2 class="hero-title">Impresión 3D 💜<br>Tu imaginación hecha realidad ⭒</h2>
          <p class="hero-subtitle">Creamos impresiones 3D personalizadas adaptadas a tus preferencias 💚</p>
          <a href="<?php echo base_url('cliente/productos'); ?>" class="btn-get-started mt-4">Ver Productos</a>
      </div>
  </section>
  <!-- /Hero Section -->

  <!-- Categories Section -->
  <section id="categories" class="categories section" data-aos="zoom-in">
    <div class="container section-title" data-aos="fade-up">
      <h2>Nuestras categorías</h2>
      <p>Explora nuestras categorías de productos impresos en 3D</p>
    </div>
    <div class="container category-container">
        <?php if (!empty($categorias)): ?>
            <?php foreach ($categorias as $categoria): ?>
              <div class="category-item" data-aos="zoom-in" data-aos-delay="100">
                <a href="<?php echo base_url('cliente/productos_por_categoria/' . $categoria->id); ?>">
                  <img src="<?php echo base_url(isset($categoria->imagen) ? trim($categoria->imagen) : 'ruta/por/defecto.jpg'); ?>" class="img-fluid rounded mb-3" alt="<?php echo isset($categoria->nombre) ? $categoria->nombre : 'Categoría'; ?>">
                </a>
                <div class="category-content">
                    <h3>
                        <a href="<?php echo base_url('cliente/productos_por_categoria/' . $categoria->id); ?>">
                            <?php echo $categoria->nombre; ?>
                        </a>
                    </h3>
                    <p><?php echo $categoria->descripcion; ?></p>
                    <span class="product-count"><?php echo $categoria->total_productos; ?> productos</span>
                </div>
              </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
              <p>No hay categorías disponibles.</p>
            </div>
        <?php endif; ?>
    </div>
  </section>
  <!-- /Categories Section -->

  <!-- About Section -->
  <section id="about" class="about section" data-aos="fade-up">
    <div class="container">
      <div class="row gy-4 align-items-center">
        <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
          <h3>Liderando el camino en la tecnología de impresión 3D</h3>
          <p class="fst-italic">
            En 3D Print Shop, transformamos tus ideas en objetos tangibles con precisión y rapidez.
          </p>
          <ul class="list-unstyled">
            <li><i class="bi bi-check-circle text-success"></i> <span>Impresiones 3D personalizadas de alta calidad</span></li>
            <li><i class="bi bi-check-circle text-success"></i> <span>Tiempos de respuesta rápidos</span></li>
            <li><i class="bi bi-check-circle text-success"></i> <span>Servicios expertos de diseño y consultoría</span></li>
            <li><i class="bi bi-check-circle text-success"></i> <span>Soporte técnico especializado</span></li>
            <li><i class="bi bi-check-circle text-success"></i> <span>Entrega puntual y segura</span></li>
            <li><i class="bi bi-check-circle text-success"></i> <span>Soluciones innovadoras y eficientes</span></li>
          </ul>
          <a href="<?php echo base_url('about'); ?>" class="read-more"><span>Leer más</span><i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
          <img src="<?php echo base_url('assets_cliente/img/about1.jpg'); ?>" class="img-fluid rounded" alt="Sobre nosotros">
        </div>
      </div>
    </div>
  </section>
  <!-- /About Section -->

  <!-- Counts Section -->
  <section id="counts" class="section counts light-background" data-aos="fade-up">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4 text-center">
        <div class="col-lg-3 col-md-6">
          <div class="stats-item w-100 h-100">
            <span data-purecounter-start="0" data-purecounter-end="1232" data-purecounter-duration="1" class="purecounter"></span>
            <p>Proyectos completados</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="stats-item w-100 h-100">
            <span data-purecounter-start="0" data-purecounter-end="64" data-purecounter-duration="1" class="purecounter"></span>
            <p>Productos disponibles</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="stats-item w-100 h-100">
            <span data-purecounter-start="0" data-purecounter-end="42" data-purecounter-duration="1" class="purecounter"></span>
            <p>Clientes felices</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="stats-item w-100 h-100">
            <span data-purecounter-start="0" data-purecounter-end="24" data-purecounter-duration="1" class="purecounter"></span>
            <p>Reconocimientos</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Counts Section -->

<!-- Why Us Section -->
<section id="why-us" class="section why-us" data-aos="fade-up">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="why-box p-4 bg-light rounded h-100">
                    <h3>¿Por qué elegir nuestra tienda de impresión 3D?</h3>
                    <p>
                        Nuestra experiencia y compromiso con la calidad garantizan que obtengas los mejores productos adaptados a tus necesidades.
                    </p>
                    <div class="text-center">
                        <a href="#" class="more-btn"><span>Aprende más</span> <i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 d-flex align-items-stretch">
                <div class="row gy-4 w-100">
                    <div class="col-xl-4 col-md-6">
                        <div class="icon-box p-4 bg-light rounded h-100">
                            <i class="bi bi-gear fs-2 text-primary"></i>
                            <h4>Tecnología avanzada</h4>
                            <p>Utilizamos la última tecnología de impresión 3D para ofrecer productos de alta calidad.</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="icon-box p-4 bg-light rounded h-100">
                            <i class="bi bi-people fs-2 text-primary"></i>
                            <h4>Equipo de expertos</h4>
                            <p>Nuestro equipo está aquí para ayudarte en cada paso del camino.</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12">
                        <div class="icon-box p-4 bg-light rounded h-100">
                            <i class="bi bi-clock fs-2 text-primary"></i>
                            <h4>Entrega oportuna</h4>
                            <p>Garantizamos la entrega oportuna de todos nuestros productos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Why Us Section -->

  <!-- Features Section -->
  <section id="features" class="features section" data-aos="fade-up">
    <div class="container">
      <div class="row gy-4 text-center">
        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="features-item icon-1">
            <i class="bi bi-printer fs-2"></i>
            <h3><a href="#" class="stretched-link">Impresiones 3D personalizadas</a></h3>
          </div>
        </div>
        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="features-item icon-2">
            <i class="bi bi-box-seam fs-2"></i>
            <h3><a href="#" class="stretched-link">Creación rápida de prototipos</a></h3>
          </div>
        </div>
        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="features-item icon-3">
            <i class="bi bi-puzzle fs-2"></i>
            <h3><a href="#" class="stretched-link">Diseño de modelos en 3D</a></h3>
          </div>
        </div>
        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
          <div class="features-item icon-4">
            <i class="bi bi-lightbulb fs-2"></i>
            <h3><a href="#" class="stretched-link">Cotizador Profecional 3D</a></h3>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Features Section -->

</main>