<main id="main" class="main">
  <div class="pagetitle">
    <h1 style="color: #28a745;">Gestión de Ventas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item active">Gestión de Ventas</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="color: var(--default-color);">Ventas</h5>

            <a href="<?php echo base_url('ventas/agregar'); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Agregar Venta
            </a>

            <a href="<?php echo base_url('ventas/pendientes'); ?>" class="btn btn-secondary">
              <i class="bi bi-hourglass-split"></i> Ver Ventas Pendientes
            </a>

            <a href="<?php echo base_url('ventas/canceladas'); ?>" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Ver Ventas Canceladas
            </a>

            <a href="<?php echo base_url('reportes'); ?>" class="btn btn-info">
              <i class="bi bi-file-earmark-text"></i> Generar Reportes
            </a>

            <table class="table">
              <thead>
                <tr>
                  <th>Cliente</th>
                  <th>Vendedor</th>
                  <th>Fecha de Venta</th>
                  <th>Total</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($ventas)) : ?>
                  <?php foreach($ventas as $venta): ?>
                    <tr>
                      <td>
                        <?php echo !empty(trim($venta->cliente_nombre . ' ' . $venta->cliente_apellido)) ? $venta->cliente_nombre . ' ' . $venta->cliente_apellido : 'Cliente no definido'; ?>
                      </td>
                      <td><?php echo $venta->usuario_nombre . ' ' . $venta->usuario_apellido; ?></td>
                      <td><?php echo $venta->fecha_venta; ?></td>
                      <td><?php echo $venta->total; ?></td>
                      <td><?php echo ucfirst($venta->estado); ?></td>
                      <td>
                        <button class="btn btn-info view-details" data-id="<?php echo $venta->id; ?>">
                          <i class="bi bi-eye"></i>
                        </button>
                        <a href="<?php echo base_url('ventas/editar/'.$venta->id); ?>" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="#" class="btn btn-danger delete-venta" data-id="<?php echo $venta->id; ?>" data-name="<?php echo $venta->cliente_nombre . ' ' . $venta->cliente_apellido; ?>">
                            <i class="bi bi-trash"></i>
                        </a>
                        <a href="<?php echo base_url('ventas/ticket_pdf/'.$venta->id); ?>" class="btn btn-success" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> Ticket
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <tr>
                    <td colspan="6" class="text-center">No hay ventas registradas.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Mostrar el script para abrir el ticket -->
<?php if ($this->session->flashdata('venta_id')): ?>
    <script>
        window.onload = function() {
            window.open("<?php echo base_url('ventas/ticket_pdf/' . $this->session->flashdata('venta_id')); ?>", "_blank");
        };
    </script>
<?php endif; ?>

<!-- Modal -->
<div class="modal fade" id="ventaDetailsModal" tabindex="-1" aria-labelledby="ventaDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="ventaDetailsModalLabel">Detalles de la Venta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Aquí se mostrarán los detalles de la venta y los productos -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-close-purple" data-bs-dismiss="modal" style="background-color: #6f42c1; border-color: #6f42c1; color: #ffffff;">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-details');
    
    viewButtons.forEach(button => {
      button.addEventListener('click', function() {
        const ventaId = this.getAttribute('data-id');
        
        fetch(`<?php echo base_url('ventas/ver_ajax/'); ?>${ventaId}`)
        .then(response => response.json())
        .then(data => {
          const modalBody = document.querySelector('#ventaDetailsModal .modal-body');
          
          let detallesHTML = `
            <table class="table">
              <tr><th>Cliente:</th><td>${data.cliente_nombre || data.cliente_apellido ? `${data.cliente_nombre} ${data.cliente_apellido}` : 'Cliente no definido'}</td></tr>
              <tr><th>Vendedor:</th><td>${data.empleado_nombre} ${data.empleado_apellido}</td></tr>
              <tr><th>Fecha de Venta:</th><td>${data.fecha_venta}</td></tr>
              <tr><th>Total:</th><td>${data.total}</td></tr>
              <tr><th>Estado:</th><td>${data.estado}</td></tr>
              <tr><th>Fecha de Creación:</th><td>${data.fecha_creacion}</td></tr>
              <tr><th>Fecha de Actualización:</th><td>${data.fecha_actualizacion}</td></tr>
              <tr><th>Usuario que realizó la última actualización:</th><td>${data.actualizador_nombre ? data.actualizador_nombre + ' ' + data.actualizador_apellido : 'N/A'}</td></tr>
            </table>
            <h5>Detalles de Productos Vendidos</h5>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Precio Unitario</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
          `;

          data.detalles_productos.forEach(detalle => {
            const subtotal = detalle.cantidad * detalle.precio_unitario;
            detallesHTML += `
              <tr>
                <td>${detalle.producto_nombre}</td>
                <td>${detalle.cantidad}</td>
                <td>${detalle.precio_unitario}</td>
                <td>${subtotal}</td>
              </tr>
            `;
          });

          detallesHTML += '</tbody></table>';
          
          modalBody.innerHTML = detallesHTML;

          const modal = new bootstrap.Modal(document.getElementById('ventaDetailsModal'));
          modal.show();
        })
        .catch(error => {
          console.error('Error al obtener los detalles de la venta:', error);
        });
      });
    });

    const deleteButtons = document.querySelectorAll('.delete-venta');
    
    deleteButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault();
        const ventaId = this.getAttribute('data-id');
        const ventaName = this.getAttribute('data-name');
        
        Swal.fire({
          title: '¿Estás seguro?',
          text: `Estás a punto de eliminar la venta realizada por ${ventaName}. ¡Esta acción no se puede deshacer!`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#6f42c1',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = `<?php echo base_url('ventas/eliminar/'); ?>${ventaId}`;
          }
        });
      });
    });
  });

</script>
