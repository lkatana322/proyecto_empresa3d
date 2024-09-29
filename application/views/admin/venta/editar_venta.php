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

            <!-- Campo de Cliente (solo lectura) -->
            <div class="col-md-6">
                <label for="cliente_id" class="form-label">Cliente</label>
                <input type="text" id="cliente_id_display" class="form-control" 
                    value="<?php echo $venta->cliente_nombre . ' ' . $venta->cliente_apellido; ?>" 
                    disabled style="background-color: #e9ecef;"> <!-- Color de fondo gris -->
                <input type="hidden" name="cliente_id" value="<?= $venta->cliente_id; ?>">
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

              <!-- Campo para mostrar la imagen del producto -->
              <div class="col-md-6">
                <label for="producto_imagen" class="form-label">Imagen del Producto</label>
                  <div id="producto-imagen-container">
                    <img id="producto_imagen" src="" alt="Imagen del producto" style="width: 100px; height: 100px; display: none;">
                  </div>
              </div>

              <!-- Productos agregados -->
              <div class="col-12">
                  <label class="form-label">Productos</label>
                  <div id="productos-container">
                      <?php foreach ($venta->detalles as $detalle): ?>
                          <div class="row g-1 align-items-center producto-item mb-2">
                              <div class="col-1">
                                  <?php if (isset($detalle->producto_imagen) && !empty($detalle->producto_imagen)): ?>
                                      <img src="<?php echo base_url($detalle->producto_imagen); ?>" alt="<?php echo $detalle->producto_nombre; ?>" style="width: 50px; height: 50px;">
                                  <?php else: ?>
                                      <img src="<?php echo base_url('assets/default-image.png'); ?>" alt="Imagen no disponible" style="width: 50px; height: 50px;"> <!-- Imagen por defecto si no hay -->
                                  <?php endif; ?>
                              </div>
                              <div class="col-md-3">
                                  <input type="text" class="form-control" value="<?= $detalle->producto_nombre; ?>" readonly>
                                  <input type="hidden" name="producto_id[]" value="<?= $detalle->producto_id; ?>">
                              </div>
                              <div class="col-md-2">
                                  <input type="number" class="form-control cantidad" name="cantidad[]" value="<?= $detalle->cantidad; ?>" min="1" required>
                              </div>
                              <div class="col-md-2">
                                  <input type="number" class="form-control precio_unitario" name="precio_unitario[]" value="<?= $detalle->precio_unitario; ?>" readonly>
                              </div>
                              <div class="col-md-2">
                                  <input type="text" class="form-control total_producto" value="<?= $detalle->precio_unitario * $detalle->cantidad; ?>" readonly>
                              </div>
                              <div class="col-md-1">
                                  <button type="button" class="btn btn-danger btn-sm remove-producto-btn"><i class="bi bi-trash" style="font-size: 1.2rem;"></i></button>
                              </div>
                          </div>
                      <?php endforeach; ?>
                  </div>
                  <button type="button" class="btn btn-secondary" id="add-producto-btn"><i class="bi bi-plus-circle"></i> Agregar Producto</button>
              </div>

              <!-- Total general de la venta alineado a la izquierda -->
              <div class="col-12 mt-3 d-flex justify-content-start">
                  <div id="total_general_container">
                      <span id="total_general_label">Total General:</span>
                      <span id="total_general_value">$ <span id="total_general"><?= array_reduce($venta->detalles, function($carry, $detalle) {
                          return $carry + ($detalle->precio_unitario * $detalle->cantidad);
                      }, 0); ?></span></span>
                  </div>
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
                            categoria_id: item.categoria_id,
                            imagen: item.imagen,
                            precio_unitario: item.precio_unitario // Asegúrate de que este campo existe en la respuesta
                        };
                    }));
                }
            });
        },
        select: function(event, ui) {
            $("#producto_hidden_id").val(ui.item.id);
            $("#producto_id").val(ui.item.value);
            $('#producto_id').data('precio', ui.item.precio_unitario); // Almacenar el precio en un data attribute
            obtenerCategoria(ui.item.id);
            if (ui.item.imagen) {
                $("#producto_imagen").attr("src", ui.item.imagen).show();
            } else {
                $("#producto_imagen").hide();
            }
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

    // Función para agregar un producto seleccionado a la lista de productos
    $('#add-producto-btn').click(function() {
        var productoId = $('#producto_hidden_id').val();
        var productoNombre = $('#producto_id').val();
        var productoImagen = $("#producto_imagen").attr("src");
        var precioUnitario = $('#producto_id').data('precio'); // Obtener el precio del data attribute
        var cantidad = 1; // Valor inicial

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

        var totalProducto = precioUnitario * cantidad;

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
                    <input type="number" class="form-control cantidad" name="cantidad[]" value="1" min="1" required>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control precio_unitario" name="precio_unitario[]" value="${precioUnitario}" readonly>
                </div>
                <div class="col-2">
                    <input type="text" class="form-control total_producto" value="${totalProducto}" readonly>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger btn-sm remove-producto-btn"><i class="bi bi-trash" style="font-size: 1.2rem;"></i></button>
                </div>
            </div>`;

        $('#productos-container').prepend(productoHtml);

        // Limpiar los campos
        $('#producto_id').val('');
        $('#producto_hidden_id').val('');
        $('#categoria_id').val('');
        $('#producto_imagen').hide();

        calcularTotal();  // Calcular el total al agregar producto
    });

    // Función para calcular el costo total del producto según la cantidad
    $(document).on('input', '.cantidad', function() {
        var row = $(this).closest('.producto-item');
        var cantidad = $(this).val();
        var precioUnitario = row.find('.precio_unitario').val();
        var totalProducto = cantidad * precioUnitario;
        row.find('.total_producto').val(totalProducto);

        calcularTotal(); // Recalcular el total general
    });

    // Función para calcular el total general
    function calcularTotal() {
        var total = 0;
        $('.total_producto').each(function() {
            total += parseFloat($(this).val());
        });
        $('#total_general').text(total.toFixed(2)); // Muestra el total general
    }

    // Inicializa el total al cargar la página
    calcularTotal();  // Asegúrate de llamar a esta función para calcular el total al cargar
    
    // Función para eliminar un producto de la lista
    $(document).on('click', '.remove-producto-btn', function() {
        $(this).closest('.producto-item').remove();
        calcularTotal();  // Recalcular el total general al eliminar un producto
    });

    // Eliminar producto de la lista
    $(document).on('click', '.remove-producto-btn', function() {
        $(this).closest('.producto-item').remove();
      });
    });
    </script>

    <style>
        #total_general_container {
        background-color: #f0f8ff;
        padding: 10px 20px;
        border: 1px solid #28a745;
        border-radius: 8px;
        display: inline-block;
        }

        #total_general_label {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
        }

        #total_general_value {
        font-size: 1.5rem;
        font-weight: bold;
        color: #28a745;
        margin-left: 10px;
        }
    </style>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
