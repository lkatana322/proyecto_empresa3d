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
              <!-- Campo oculto para el ID de la venta -->
              <input type="hidden" name="id" value="<?= $venta->id; ?>">

              <!-- Selección de Cliente -->
              <div class="col-md-6">
                  <label for="cliente_id" class="form-label">Cliente</label>
                  <select id="cliente_id" name="cliente_id" class="form-select" required>
                      <option value="" disabled>Seleccione un cliente</option>
                      <?php foreach($clientes as $cliente): ?>
                          <option value="<?php echo $cliente->id; ?>" <?= $cliente->id == $venta->cliente_id ? 'selected' : ''; ?>><?php echo $cliente->nombre . ' ' . $cliente->apellido; ?></option>
                      <?php endforeach; ?>
                  </select>
                  <div class="invalid-feedback">¡Por favor, seleccione un cliente!</div>
              </div>

              <!-- Empleado (Usuario que hace la venta) -->
              <div class="col-md-6">
                  <label for="usuario_id" class="form-label">Empleado</label>
                  <input type="text" class="form-control" value="<?= $usuario_logueado; ?>" disabled>
                  <input type="hidden" name="usuario_id" value="<?= $this->session->userdata('user_id'); ?>"> 
              </div>

              <!-- Búsqueda de Producto con autocompletado -->
              <div class="col-md-6">
                <label for="producto_id" class="form-label">Buscar Producto</label>
                <div class="input-group">
                  <span class="input-group-text" style="background-color: #f0f8ff; border-color: #28a745;">
                    <i class="bi bi-search" style="color: #28a745; font-size: 1.2em;"></i>
                  </span>
                  <input type="text" id="producto_id" name="producto_id" class="form-control" placeholder="Buscar Producto..." style="border-color: #28a745;">
                  <input type="hidden" id="producto_hidden_id" name="producto_hidden_id">
                  <div class="invalid-feedback">¡Por favor, seleccione un producto!</div>
                </div>
              </div>

              <!-- Campo de Categoría -->
              <div class="col-md-6">
                <label for="categoria_id" class="form-label">Categoría</label>
                <input type="text" id="categoria_id" name="categoria_id" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;">
              </div>

              <!-- Productos agregados -->
              <div class="col-12">
                <label class="form-label">Productos</label>
                <div id="productos-container">
                  <!-- Cargar productos previamente agregados en la venta -->
                  <?php foreach ($venta->detalles as $detalle): ?>
                    <div class="row g-3 align-items-center producto-item mb-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?= $detalle->producto_nombre; ?>" readonly>
                            <input type="hidden" name="producto_id[]" value="<?= $detalle->producto_id; ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="cantidad[]" value="<?= $detalle->cantidad; ?>" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="precio_unitario[]" value="<?= $detalle->precio_unitario; ?>" readonly>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm remove-producto-btn"><i class="bi bi-trash" style="font-size: 1.2rem;"></i></button>
                        </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-secondary" id="add-producto-btn"><i class="bi bi-plus-circle"></i> Agregar Producto</button>
              </div>

              <!-- Estado de la Venta -->
              <div class="col-md-6">
                <label for="estado_venta" class="form-label">Estado</label>
                <select id="estado_venta" name="estado_venta" class="form-select" required>
                  <option value="pendiente" <?= $venta->estado == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                  <option value="completada" <?= $venta->estado == 'completada' ? 'selected' : ''; ?>>Completada</option>
                  <option value="cancelada" <?= $venta->estado == 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                </select>
                <div class="invalid-feedback">¡Por favor, seleccione un estado para la venta!</div>
              </div>

              <!-- Botones de Guardar/Cancelar -->
              <div class="col-12 mt-4 d-flex justify-content-start">
                  <button class="btn btn-success custom-btn me-2" type="submit">
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
<link rel="stylesheet" href="<?php echo base_url('assets_admin/jquery/css/jquery-ui.structure.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets_admin/jquery/css/jquery-ui.theme.min.css'); ?>">
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
                                            label: item.nombre,
                                            value: item.nombre,
                                            id: item.id,
                                            categoria_id: item.categoria_id
                                        };
                                    }));
                                }
                            });
                        },
                        select: function(event, ui) {
                            $("#producto_hidden_id").val(ui.item.id);  // Guardar el ID del producto seleccionado
                            $("#producto_id").val(ui.item.value);      // Llenar el cuadro con el nombre del producto
                            obtenerCategoria(ui.item.id);              // Llamar a la función para obtener la categoría
                            return false;
                        },
                        minLength: 2
                    });

                    // Función para obtener la categoría del producto seleccionado
                    function obtenerCategoria(producto_id) {
                        $.ajax({
                            url: "<?php echo base_url('categorias/get_categoria_by_producto'); ?>",
                            dataType: "json",
                            data: { producto_id: producto_id },
                            success: function(data) {
                                if (data.categoria) {
                                    $("#categoria_id").val(data.categoria.nombre);
                                } else {
                                    $("#categoria_id").val('');
                                }
                            }
                        });
                    }

                    // Agregar producto a la lista
                    $('#add-producto-btn').click(function() {
                        var productoId = $('#producto_hidden_id').val();
                        var productoNombre = $('#producto_id').val();
                        var categoriaNombre = $('#categoria_id').val();

                        if (!productoId || !productoNombre) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Debe seleccionar un producto antes de agregarlo.',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                            return false;
                        }

                        var productoHtml = `
                            <div class="row g-3 align-items-center producto-item mb-2">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" value="${productoNombre}" readonly>
                                    <input type="hidden" name="producto_id[]" value="${productoId}">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="cantidad[]" value="1" min="1" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="precio_unitario[]" value="320" readonly>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-producto-btn"><i class="bi bi-trash" style="font-size: 1.2rem;"></i></button>
                                </div>
                            </div>`;
                        
                        $('#productos-container').append(productoHtml);

                        // Limpiar campos
                        $('#producto_id').val('');
                        $('#producto_hidden_id').val('');
                        $('#categoria_id').val('');
                    });

                    // Eliminar producto de la lista
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
