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
                  <div class="input-group">
                    <span class="input-group-text" style="background-color: #f0f8ff; border-color: #28a745;">
                      <i class="bi bi-search" style="color: #28a745; font-size: 1.2em;"></i> <!-- Ícono de lupa con estilo mejorado -->
                    </span>
                    <input type="text" id="producto_id" name="producto_id" class="form-control" placeholder="Buscar Producto..." style="border-color: #28a745;">
                    <input type="hidden" id="producto_hidden_id" name="producto_hidden_id">
                    <div class="invalid-feedback">¡Por favor, seleccione un producto!</div>
                  </div>
                </div>

                <!-- Campo de categoría basado en el producto seleccionado -->
                <div class="col-md-6">
                  <label for="categoria_id" class="form-label">Categoría</label>
                  <input type="text" id="categoria_id" name="categoria_id" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                </div>

                <!-- Campo para mostrar la imagen del producto -->
                <div class="col-md-6">
                  <label for="producto_imagen" class="form-label">Imagen del Producto</label>
                  <div id="producto-imagen-container">
                    <img id="producto_imagen" src="" alt="Imagen del producto" style="width: 100px; height: 100px; display: none;">
                  </div>
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
                    <option value="completada" selected>Completada</option>
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
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script src="<?php echo base_url('assets_admin/jquery/js/jquery-3.7.1.min.js'); ?>"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets_admin/jquery/css/jquery-ui.min.css'); ?>">
  <script src="<?php echo base_url('assets_admin/jquery/js/jquery-ui.min.js'); ?>"></script>

  <script>
  $(document).ready(function() {
      // Autocompletado del campo de búsqueda de productos
      $("#producto_id").autocomplete({
          source: function(request, response) {
              $.ajax({
                  url: "<?php echo base_url('productos/buscar_producto_ajax'); ?>",
                  dataType: "json",
                  data: {
                      query: request.term
                  },
                  success: function(data) {
                      response($.map(data, function(item) {
                          return {
                              label: item.nombre,    // Lo que se muestra en el autocompletado
                              value: item.nombre,    // El valor que se coloca en el input
                              id: item.id,           // ID del producto
                              categoria_id: item.categoria_id,  // ID de la categoría
                              imagen: item.imagen    // URL de la imagen del producto
                          };
                      }));
                  }
              });
          },
          select: function(event, ui) {
              $("#producto_hidden_id").val(ui.item.id);  // Guardar el ID del producto seleccionado
              $("#producto_id").val(ui.item.value);      // Llenar el cuadro con el nombre del producto
              obtenerCategoria(ui.item.id);              // Llamar a la función para obtener la categoría
              
              // Mostrar la imagen del producto seleccionado
              if (ui.item.imagen) {
                  $("#producto_imagen").attr("src", ui.item.imagen).show();
              } else {
                  $("#producto_imagen").hide(); // Si no tiene imagen, ocultamos el contenedor de la imagen
              }

              return false;
          },
          minLength: 2  // Número mínimo de caracteres para empezar a buscar
      });

      // Función para obtener la categoría del producto seleccionado
      function obtenerCategoria(producto_id) {
          $.ajax({
              url: "<?php echo base_url('categorias/get_categoria_by_producto'); ?>",
              dataType: "json",
              data: { producto_id: producto_id },
              success: function(data) {
                  if (data.categoria) {
                      $("#categoria_id").val(data.categoria.nombre); // Asigna el nombre de la categoría
                  } else {
                      $("#categoria_id").val(''); // Deja en blanco si no encuentra categoría
                  }
              }
          });
      }

      // Función para agregar un producto seleccionado a la lista de productos
      $('#add-producto-btn').click(function() {
          var productoId = $('#producto_hidden_id').val();
          var productoNombre = $('#producto_id').val();
          var categoriaNombre = $('#categoria_id').val();
          var productoImagen = $("#producto_imagen").attr("src"); // Obtener la URL de la imagen del producto actual

          if (!productoId || !productoNombre) {
              // Mostrar mensaje de error usando SweetAlert2
              Swal.fire({
                  icon: 'error',  // Ícono de error
                  title: 'Error',  // Título del modal
                  text: 'Debe seleccionar un producto antes de agregarlo.',  // Mensaje personalizado
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK'
              });
              return false;  // Prevenir que se agregue un producto vacío
          }

          if (productoId && productoNombre) {
            var productoImagen = $("#producto_imagen").attr("src"); // Obtener la URL de la imagen del producto actual

            var productoHtml = `
                <div class="row g-1 align-items-center producto-item mb-2">
                    <div class="col-1">
                        <img src="${productoImagen}" alt="${productoNombre}" style="width: 50px; height: 50px;">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" value="${productoNombre}" readonly>
                        <input type="hidden" name="producto_id[]" value="${productoId}">
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control" name="cantidad[]" value="1" min="1" required>
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control" name="precio_unitario[]" value="320" readonly>
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-danger btn-sm remove-producto-btn"><i class="bi bi-trash" style="font-size: 1.2rem;"></i></button>
                    </div>
                </div>`;

            $('#productos-container').prepend(productoHtml);

            // Limpiar los campos de búsqueda y categoría
            $('#producto_id').val('');
            $('#producto_hidden_id').val('');
            $('#categoria_id').val('');
            $('#producto_imagen').hide();  // Ocultar la imagen una vez agregado el producto
        }
      });

      // Función para eliminar un producto de la lista
      $(document).on('click', '.remove-producto-btn', function() {
          $(this).closest('.producto-item').remove();
      });
  });
  </script>


          </div>
        </div>
      </div>
    </div>
  </section>
</main>
