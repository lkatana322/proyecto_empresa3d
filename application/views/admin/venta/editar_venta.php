<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar Venta</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('ventas'); ?>">Gestión de Ventas</a></li>
        <li class="breadcrumb-item active">Editar Venta</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Formulario de Editar Venta</h5>

            <!-- Formulario de Editar Venta -->
            <form class="row g-3 needs-validation" novalidate action="<?= base_url('ventas/actualizar') ?>" method="post" id="formEditarVenta">
              <input type="hidden" name="id" value="<?= $venta->id ?>">

              <div class="col-md-6">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select id="cliente_id" name="cliente_id" class="form-select" required>
                  <option value="" disabled>Seleccione un cliente</option>
                  <?php foreach($clientes as $cliente): ?>
                    <option value="<?php echo $cliente->id; ?>" <?php echo ($cliente->id == $venta->cliente_id) ? 'selected' : ''; ?>>
                      <?php echo $cliente->nombre . ' ' . $cliente->apellido; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">¡Por favor, seleccione un cliente!</div>
              </div>

              <div class="col-md-6">
                  <label for="usuario_id" class="form-label"><?= ucfirst($rol_usuario_logueado); ?></label>
                  <input type="text" class="form-control" value="<?= $usuario_logueado; ?>" disabled>
                  <input type="hidden" name="usuario_id" value="<?= $this->session->userdata('user_id'); ?>"> 
              </div>

              <div class="col-md-6">
                <label for="categoria_id" class="form-label">Categoría</label>
                <select id="categoria_id" name="categoria_id" class="form-select" required>
                  <option value="" disabled>Seleccione una categoría</option>
                  <?php foreach($categorias as $categoria): ?>
                    <option value="<?php echo $categoria->id; ?>" <?php echo ($categoria->id == $venta->categoria_id) ? 'selected' : ''; ?>>
                      <?php echo $categoria->nombre; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">¡Por favor, seleccione una categoría!</div>
              </div>

              <div class="col-12">
                <label class="form-label">Productos</label>
                <div id="productos-container">
                  <?php foreach ($venta->detalles as $detalle): ?>
                    <div class="row g-3 align-items-center mb-3">
                      <div class="col-sm-4">
                        <select name="producto_id[]" class="form-select" required>
                          <option value="" disabled>Seleccione un producto</option>
                          <?php foreach($productos as $producto): ?>
                            <option value="<?php echo $producto->id; ?>" <?php echo ($producto->id == $detalle->producto_id) ? 'selected' : ''; ?>>
                              <?php echo $producto->nombre; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">¡Por favor, seleccione un producto!</div>
                      </div>
                      <div class="col-sm-3">
                        <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" required min="1" value="<?= $detalle->cantidad ?>">
                        <div class="invalid-feedback">¡Por favor, ingrese una cantidad válida!</div>
                      </div>
                      <div class="col-sm-3">
                        <input type="number" name="precio_unitario[]" class="form-control" placeholder="Precio Unitario" required step="0.01" min="0" value="<?= $detalle->precio_unitario ?>">
                        <div class="invalid-feedback">¡Por favor, ingrese un precio unitario válido!</div>
                      </div>
                      <div class="col-sm-2">
                        <button type="button" class="btn btn-danger remove-producto"><i class="bi bi-trash"></i></button>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-secondary" id="add-producto-btn"><i class="bi bi-plus-circle"></i> Agregar Producto</button>
              </div>

              <div class="col-md-6">
                <label for="estado_venta" class="form-label">Estado</label>
                <select id="estado_venta" name="estado_venta" class="form-select" required>
                  <option value="pendiente" <?php echo ($venta->estado == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                  <option value="completada" <?php echo ($venta->estado == 'completada') ? 'selected' : ''; ?>>Completada</option>
                  <option value="cancelada" <?php echo ($venta->estado == 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                </select>
                <div class="invalid-feedback">¡Por favor, seleccione un estado para la venta!</div>
              </div>

              <div class="col-12 mt-4 d-flex justify-content-start">
                <button class="btn btn-success custom-btn me-2" type="submit" id="btnEditarVenta">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="<?php echo base_url('ventas'); ?>" class="btn btn-secondary custom-btn">
                    <i class="fas fa-times"></i> Cancelar
                </a>
              </div>

            </form>
            <!-- End Formulario de Editar Venta -->

            <script>
              document.addEventListener('DOMContentLoaded', function() {
                const formEditarVenta = document.getElementById('formEditarVenta');
                const btnEditarVenta = document.getElementById('btnEditarVenta');
                const addProductoBtn = document.getElementById('add-producto-btn');
                const productosContainer = document.getElementById('productos-container');
                const categoriaSelect = document.getElementById('categoria_id');

                // AJAX para cargar productos según la categoría seleccionada
                categoriaSelect.addEventListener('change', function() {
                  const categoriaId = this.value;

                  if (categoriaId) {
                    fetch('<?php echo base_url('productos/get_productos_by_categoria/'); ?>' + categoriaId)
                      .then(response => response.json())
                      .then(data => {
                        productosContainer.innerHTML = ''; // Limpiar el contenedor de productos
                        data.forEach(producto => {
                          agregarProductoRow(producto);
                        });
                      });
                  }
                });

                // Agregar una fila de producto manualmente
                addProductoBtn.addEventListener('click', function() {
                  agregarProductoRow();
                });

                // Función para agregar una fila de producto
                function agregarProductoRow(producto = {}) {
                  const newProductoRow = `
                    <div class="row g-3 align-items-center mb-3">
                      <div class="col-sm-4">
                        <select name="producto_id[]" class="form-select" required>
                          <option value="" disabled ${!producto.id ? 'selected' : ''}>Seleccione un producto</option>
                          <?php foreach($productos as $producto): ?>
                            <option value="<?php echo $producto->id; ?>" ${producto.id === '<?php echo $producto->id; ?>' ? 'selected' : ''}"><?php echo $producto->nombre; ?></option>
                          <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">¡Por favor, seleccione un producto!</div>
                      </div>
                      <div class="col-sm-3">
                        <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" required min="1" value="${producto.cantidad || ''}">
                        <div class="invalid-feedback">¡Por favor, ingrese una cantidad válida!</div>
                      </div>
                      <div class="col-sm-3">
                        <input type="number" name="precio_unitario[]" class="form-control" placeholder="Precio Unitario" required step="0.01" min="0" value="${producto.precio || ''}">
                        <div class="invalid-feedback">¡Por favor, ingrese un precio unitario válido!</div>
                      </div>
                      <div class="col-sm-2">
                        <button type="button" class="btn btn-danger remove-producto"><i class="bi bi-trash"></i></button>
                      </div>
                    </div>
                  `;
                  productosContainer.insertAdjacentHTML('beforeend', newProductoRow);
                }

                // Eliminar una fila de producto
                productosContainer.addEventListener('click', function(e) {
                  if (e.target.classList.contains('remove-producto')) {
                    e.target.closest('.row').remove();
                  }
                });

                // Validación del formulario
                formEditarVenta.addEventListener('submit', function(event) {
                  if (!formEditarVenta.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    formEditarVenta.classList.add('was-validated');
                  } else {
                    btnEditarVenta.disabled = true;
                    btnEditarVenta.textContent = 'Guardando...';
                  }
                });
              });
            </script>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
