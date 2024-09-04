<main class="content-main">

    <!-- Título de la Página -->
    <div class="container section-title text-center" data-aos="fade-up">
        <h2 class="category-title">Catálogo de Productos</h2>
        <div class="title-divider"></div>
        <p class="category-subtitle">Sumérgete en la variedad de productos impresos en 3D que ofrecemos</p>
    </div>

    <!-- Barra de herramientas con opciones de filtrado y botón de retorno -->
    <div class="container mb-4 toolbar d-flex justify-content-between align-items-center">
        <div class="toolbar-left d-flex gap-3">
            <a href="<?php echo base_url(); ?>" class="btn-return-home">Volver al Inicio</a>

            <!-- Dropdown para categorías -->
            <?php if (!empty($categorias)): ?>
            <div class="dropdown">
                <button class="btn-category-dropdown dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Categorías
                </button>
                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                    <li><a class="dropdown-item" href="<?php echo base_url('cliente/productos'); ?>">Ver Todos los Productos</a></li>
                    <?php foreach ($categorias as $categoria): ?>
                        <li><a class="dropdown-item" href="<?php echo base_url('cliente/productos/categoria/' . $categoria->id); ?>"><?php echo $categoria->nombre; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <div class="toolbar-right d-flex gap-3">
            <button class="btn-filter">Ordenar por precio</button>
            <button class="btn-filter">Ordenar por popularidad</button>
        </div>
    </div>

    <div class="container productos-container">
        <div class="d-flex flex-wrap justify-content-center gap-4">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto-item" data-aos="zoom-in" data-aos-delay="100">
                        <img src="<?php echo base_url(isset($producto->imagen) ? trim($producto->imagen) : 'ruta/por/defecto.jpg'); ?>" class="img-fluid rounded mb-3" alt="<?php echo isset($producto->nombre) ? $producto->nombre : 'Producto'; ?>">
                        <div class="producto-content">
                            <h3><a href="<?php echo base_url('producto/detalle/' . $producto->id); ?>"><?php echo $producto->nombre; ?></a></h3>
                            <p><?php echo $producto->descripcion; ?></p>
                            <p><strong>Categoría:</strong> <?php echo $producto->categoria_nombre; ?></p>
                            <p><strong>Precio:</strong> <?php echo $producto->precio; ?> Bs</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>No hay productos disponibles.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</main>
