<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Venta</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('ventas'); ?>">Gestión de Ventas</a></li>
        <li class="breadcrumb-item active">Agregar Venta</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Formulario de Agregar Venta</h5>

            <!-- Formulario de Agregar Venta -->
            <form class="row g-3 needs-validation" novalidate action="<?= base_url('ventas/guardar') ?>" method="post" id="formAgregarVenta">
              
              <div class="col-md-6">
                  <label for="cliente_id" class="form-label">Cliente</label>
                  <select id="cliente_id" name="cliente_id" class="form-select" required>
                      <option value="" disabled selected>Seleccione un cliente</option>
                      <?php foreach($clientes as $cliente): ?>
                          <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->nombre . ' ' . $cliente->apellido; ?></option>
                      <?php endforeach; ?>
                  </select>
                  <div class="invalid-feedback">¡Por favor, seleccione un cliente!</div>
              </div>

              <div class="col-md-6">
                  <label for="usuario_id" class="form-label"><?= ucfirst($rol_usuario_logueado); ?></label>
                  <input type="text" class="form-control" value="<?= $usuario_logueado; ?>" disabled>
                  <input type="hidden" name="usuario_id" value="<?= $this->session->userdata('user_id'); ?>"> 
              </div>

              <!-- Búsqueda de Producto con autocompletado -->
              <div class="col-md-6">
                <label for="producto_id" class="form-label">Buscar Producto</label>
                <input type="text" id="producto_id" name="producto_id" class="form-control" placeholder="Buscar Producto...">
                <input type="hidden" id="producto_hidden_id" name="producto_hidden_id">
                <div class="invalid-feedback">¡Por favor, seleccione un producto!</div>
              </div>

              <!-- Campo de categoría basado en el producto seleccionado -->
              <div class="col-md-6">
                <label for="categoria_id" class="form-label">Categoría</label>
                <input type="text" id="categoria_id" name="categoria_id" class="form-control" readonly>
              </div>

              <!-- Productos agregados dinámicamente -->
              <div class="col-12">
                <label class="form-label">Productos</label>
                <div id="productos-container">
                  <!-- Aquí se irán agregando los productos seleccionados -->
                </div>
                <button type="button" class="btn btn-secondary" id="add-producto-btn"><i class="bi bi-plus-circle"></i> Agregar Producto</button>
              </div>

              <div class="col-md-6">
                <label for="estado_venta" class="form-label">Estado</label>
                <select id="estado_venta" name="estado_venta" class="form-select" required>
                  <option value="pendiente">Pendiente</option>
                  <option value="completada" selected>Completada</option> <!-- Establecer Completada como seleccionada -->
                  <option value="cancelada">Cancelada</option>
                </select>
                <div class="invalid-feedback">¡Por favor, seleccione un estado para la venta!</div>
              </div>

              <div class="col-12 mt-4 d-flex justify-content-start">
                  <button class="btn btn-success custom-btn me-2" type="submit" id="btnAgregarVenta">
                      <i class="fas fa-save"></i> Guardar
                  </button>
                  <a href="<?php echo base_url('ventas'); ?>" class="btn btn-secondary custom-btn">
                      <i class="fas fa-times"></i> Cancelar
                  </a>
              </div>

            </form>
            <!-- End Formulario de Agregar Venta -->

            <script>
              document.addEventListener('DOMContentLoaded', function() {
                  const productoInput = document.getElementById('producto_id');
                  const productoHiddenInput = document.getElementById('producto_hidden_id');
                  const categoriaInput = document.getElementById('categoria_id');
                  const addProductoBtn = document.getElementById('add-producto-btn');
                  const productosContainer = document.getElementById('productos-container');
                  const formAgregarVenta = document.getElementById('formAgregarVenta');

                  // Manejo del botón Agregar Producto
                  addProductoBtn.addEventListener('click', function() {
                      const productoId = productoHiddenInput.value;

                      if (!productoId) {
                          Swal.fire({
                              icon: 'warning',
                              title: 'Producto no seleccionado',
                              text: 'Por favor, busque y seleccione un producto primero.',
                              confirmButtonText: 'Aceptar',
                              confirmButtonColor: '#3085d6'
                          });
                      } else {
                          agregarProductoRow();
                      }
                  });

                  // Función para agregar una fila de producto
                  function agregarProductoRow() {
                      const productoNombre = productoInput.value;
                      const productoId = productoHiddenInput.value;
                      
                      // Código para agregar la fila del producto al contenedor
                      const newProductoRow = `
                          <div class="row g-3 align-items-center mb-3">
                              <div class="col-sm-4">
                                  <input type="text" class="form-control" value="${productoNombre}" readonly>
                                  <input type="hidden" name="producto_id[]" value="${productoId}">
                              </div>
                              <div class="col-sm-3">
                                  <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" required min="1" value="1">
                              </div>
                              <div class="col-sm-3">
                                  <input type="number" name="precio_unitario[]" class="form-control" placeholder="Precio Unitario" required step="0.01" min="0" value="320">
                              </div>
                              <div class="col-sm-2">
                                  <button type="button" class="btn btn-danger remove-producto"><i class="bi bi-trash"></i></button>
                              </div>
                          </div>
                      `;

                      productosContainer.insertAdjacentHTML('beforeend', newProductoRow);

                      // Limpiamos los campos de búsqueda de producto
                      productoInput.value = '';
                      productoHiddenInput.value = '';
                      categoriaInput.value = '';
                  }

                  // Eliminar una fila de producto
                  productosContainer.addEventListener('click', function(e) {
                      if (e.target.classList.contains('remove-producto')) {
                          e.target.closest('.row').remove();
                      }
                  });

                  // Simulación de búsqueda de productos con AJAX
                  productoInput.addEventListener('input', function() {
                      const searchQuery = this.value;

                      if (searchQuery.length > 2) {
                          fetch('<?php echo base_url('productos/buscar_producto?query='); ?>' + searchQuery)
                              .then(response => response.json())
                              .then(data => {
                                  if (data.productos.length > 0) {
                                      const producto = data.productos[0]; // Tomamos el primer resultado como ejemplo
                                      productoInput.value = producto.nombre;
                                      productoHiddenInput.value = producto.id;

                                      // Obtener la categoría del producto seleccionado
                                      fetch('<?php echo base_url('categorias/get_categoria_by_producto/'); ?>' + producto.id)
                                          .then(response => response.json())
                                          .then(data => {
                                              categoriaInput.value = data.categoria.nombre;
                                          });
                                  } else {
                                      categoriaInput.value = 'No se encontró categoría';
                                  }
                              });
                      }
                  });

                  // Validar formulario solo cuando sea necesario
                  formAgregarVenta.addEventListener('submit', function(e) {
                      const productoId = productoHiddenInput.value;
                      if (productoId && productoInput.value) {
                          // No se está agregando un producto, continuar con el guardado de la venta
                      } else {
                          // Verificamos si al menos un producto ha sido añadido
                          if (productosContainer.children.length === 0) {
                              e.preventDefault();
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Error',
                                  text: 'Debe agregar al menos un producto antes de guardar la venta.'
                              });
                          }
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
