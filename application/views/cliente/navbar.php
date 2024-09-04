<header>
    <!-- Navegación principal de la página -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Marca y logo que redirige a la página principal -->
            <a class="navbar-brand d-flex align-items-center" href="<?php echo base_url(); ?>">
                <!-- Logo de la empresa -->
                <img src="<?php echo base_url('assets_admin/img/logo.png'); ?>" alt="3DPrintShop Logo" class="me-2">
                <span class="h4 mb-0">3DPrintShop</span> <!-- Nombre de la empresa al lado del logo -->
            </a>

            <!-- Botón de hamburguesa para dispositivos móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span> <!-- Icono de hamburguesa -->
            </button>

            <!-- Menú Offcanvas para navegación en móviles -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarNav" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menú</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <!-- Menú de navegación -->
                    <ul class="navbar-nav ms-auto align-items-center"> <!-- Alinea los elementos de navegación a la derecha -->
                        
                        <!-- Elementos del menú de navegación -->
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo base_url(); ?>" style="color: #5fcf80;">Inicio</a> <!-- Enlace a la página principal -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('about'); ?>">Nosotros</a> <!-- Enlace a la sección "Nosotros" -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('events'); ?>">Eventos</a> <!-- Enlace a la sección de eventos -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('cliente/cotizador3d'); ?>">Cotizador 3D</a> <!-- Enlace al cotizador 3D -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('contact'); ?>">Contacto</a> <!-- Enlace a la sección de contacto -->
                        </li>
                        
                        <!-- Dropdown para la sección de Productos, visible solo si hay categorías disponibles -->
                        <?php if (!empty($categorias)): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Productos <!-- Título del dropdown -->
                            </a>
                            <!-- Lista desplegable de categorías de productos -->
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?php echo base_url('cliente/productos'); ?>">Ver Todos los Productos</a></li> <!-- Enlace para ver todos los productos -->
                                <!-- Itera sobre las categorías y crea un enlace para cada una -->
                                <?php foreach ($categorias as $categoria): ?>
                                    <li><a class="dropdown-item" href="<?php echo base_url('cliente/productos_por_categoria/' . $categoria->id); ?>"><?php echo $categoria->nombre; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <!-- Botón para iniciar sesión -->
                        <li class="nav-item ms-3">
                            <a class="btn btn-login" href="<?php echo base_url('auth/login'); ?>">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </a>
                        </li>
                    </ul>
                </div> <!-- Fin del cuerpo del Offcanvas -->
            </div> <!-- Fin del Offcanvas -->
        </div> <!-- Fin del contenedor fluido -->
    </nav>
</header>
