<main class="main">

    <!-- Page Title -->
    <div class="container section-title text-center" data-aos="fade-up">
        <h2 class="category-title">Detalles del Producto</h2>
        <div class="title-divider"></div>
        <p class="category-subtitle">Aquí encontrarás todos los detalles sobre nuestro producto.</p>
    </div>

    <!-- Breadcrumbs -->
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


    <!-- Product Details Section -->
    <section id="product-details" class="product-details section py-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <!-- Product Image -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="product-image">
                        <img src="<?php echo base_url($producto->imagen); ?>" class="img-fluid rounded shadow-sm" alt="<?php echo $producto->nombre; ?>">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="product-info">
                        <h2 class="product-title"><?php echo $producto->nombre; ?></h2>
                        <p class="product-category"><strong>Categoría:</strong> <?php echo $producto->categoria_nombre; ?></p>
                        <p class="product-description"><strong>Descripción:</strong> <?php echo isset($producto->descripcion_completa) ? $producto->descripcion_completa : 'No disponible'; ?></p>
                        <p class="product-specs"><strong>Especificaciones:</strong> <?php echo isset($producto->especificaciones) ? $producto->especificaciones : 'No disponible'; ?></p>
                        <p class="product-reviews"><strong>Reseñas:</strong> <?php echo isset($producto->resenas) ? $producto->resenas : 'No disponible'; ?></p>
                        <p class="product-stock"><strong>Disponibilidad:</strong> 
                            <?php 
                            if ($producto->stock > 0) {
                                echo $producto->stock . ' unidades disponibles';
                            } else {
                                echo 'Agotado';
                            }
                            ?>
                        </p>
                        <p class="product-price"><strong>Precio:</strong> <?php echo $producto->precio; ?> Bs.</p>
                        
                        <!-- Add to Cart Button -->
                        <div class="mt-4">
                            <a href="<?php echo base_url('carrito/agregar/' . $producto->id); ?>" class="btn-add-to-cart btn btn-success btn-lg">Agregar al Carrito</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Product Details Section -->

    <!-- Tabs Section -->
    <section id="tabs" class="tabs section py-5">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-3">
                    <ul class="nav nav-tabs flex-column">
                        <li class="nav-item">
                            <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">Descripción</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-2">Especificaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-3">Reseñas</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9 mt-4 mt-lg-0">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab-1">
                            <div class="details">
                                <h3>Descripción Completa del Producto</h3>
                                <p class="fst-italic">Aquí se proporciona una descripción más completa del producto, sus características y beneficios.</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-2">
                            <div class="details">
                                <h3>Especificaciones Técnicas</h3>
                                <p class="fst-italic">Aquí se detallan las especificaciones técnicas del producto, como dimensiones, materiales, etc.</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-3">
                            <div class="details">
                                <h3>Reseñas de Clientes</h3>
                                <p class="fst-italic">Aquí se muestran las reseñas de los clientes que han comprado este producto.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Tabs Section -->

</main>
