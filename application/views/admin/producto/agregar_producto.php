<main id="main" class="main">
  <div class="pagetitle">
    <h1 style="color: #28a745;">Agregar Producto</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('productos'); ?>">Gestión de Productos</a></li>
        <li class="breadcrumb-item active">Agregar Producto</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title" style="color: var(--default-color);">Nuevo Producto</h5>

            <form class="row g-3 needs-validation" novalidate action="<?php echo base_url('productos/guardar'); ?>" method="post" enctype="multipart/form-data" id="formAgregarProducto">
              <div class="col-md-6">
                <label for="nombre_producto" class="form-label">Nombre</label>
                <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" placeholder="Ingrese el nombre del producto" required pattern="^[A-Za-z0-9\s]+$">
                <div class="invalid-feedback">¡Por favor, ingrese un nombre válido!</div>
              </div>

              <div class="col-md-6">
                <label for="descripcion_producto" class="form-label">Descripción</label>
                <textarea name="descripcion_producto" id="descripcion_producto" class="form-control" placeholder="Descripción detallada del producto" required></textarea>
                <div class="invalid-feedback">¡Por favor, ingrese una descripción válida!</div>
              </div>

              <div class="col-md-6">
                <label for="precio_producto" class="form-label">Precio</label>
                <input type="number" name="precio_producto" id="precio_producto" class="form-control" placeholder="Precio en bolivianos" step="0.01" required>
                <div class="invalid-feedback">¡Por favor, ingrese un precio válido!</div>
              </div>

              <div class="col-md-6">
                <label for="stock_producto" class="form-label">Cantidad</label>
                <input type="number" name="stock_producto" id="stock_producto" class="form-control" placeholder="Cantidad disponible en stock" required>
                <div class="invalid-feedback">¡Por favor, ingrese una cantidad válida de stock!</div>
              </div>

              <div class="col-md-6">
                <label for="categoria_id" class="form-label">Categoría</label>
                <select name="categoria_id" id="categoria_id" class="form-control" required>
                  <option value="" disabled selected>Seleccione una categoría</option>
                  <?php foreach($categorias as $categoria): ?>
                    <option value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">¡Por favor, seleccione una categoría!</div>
              </div>

              <div class="col-md-6">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                <div class="invalid-feedback">¡Por favor, suba una imagen válida!</div>
              </div>

              <div class="col-md-6">
                <label for="estado_producto" class="form-label">Estado</label>
                <select name="estado_producto" id="estado_producto" class="form-control" required>
                  <option value="activo">Activo</option>
                  <option value="inactivo">Inactivo</option>
                </select>
                <div class="invalid-feedback">¡Por favor, seleccione un estado!</div>
              </div>

              <div class="col-md-12 mt-4 d-flex justify-content-start">
                <button type="submit" class="btn btn-success me-2">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="<?php echo base_url('productos'); ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
              </div>
              
            </form>

            <script>
              function previewImage() {
                const preview = document.getElementById('imagenPreview');
                const file = document.getElementById('imagen').files[0];
                const reader = new FileReader();

                reader.onloadend = function() {
                  preview.src = reader.result;
                  preview.style.display = 'block';
                };

                if (file) {
                  reader.readAsDataURL(file);
                } else {
                  preview.src = '';
                  preview.style.display = 'none';
                }
              }
            </script>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
