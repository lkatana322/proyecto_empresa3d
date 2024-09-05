<main id="main" class="main">
  <div class="pagetitle">
    <h1 style="color: #28a745;">Gestión de Clientes</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item active">Gestión de Clientes</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="color: var(--default-color);">Clientes</h5>

            <a href="<?php echo base_url('usuarios/agregar'); ?>" class="btn btn-primary add-user-btn <?php echo ($this->session->userdata('rol') == 'empleado') ? 'disabled' : ''; ?>">
                <i class="bi bi-plus-circle"></i> Agregar Cliente
            </a>

            <a href="<?= base_url('usuarios/clientes_inactivos') ?>" class="btn btn-secondary">
                <i class="bi bi-people-fill"></i> Ver Clientes Inactivos
            </a>
            
            <table class="table">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>2°Apellido</th>
                  <th>Email</th>
                  <th>Teléfono</th>
                  <th>Dirección</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($clientes)) : ?>
                  <?php foreach($clientes as $cliente): ?>
                    <tr>
                      <td><?php echo $cliente->nombre; ?></td>
                      <td><?php echo $cliente->apellido; ?></td>
                      <td><?php echo isset($cliente->segundo_apellido) ? $cliente->segundo_apellido : 'N/A'; ?></td>
                      <td><?php echo $cliente->email; ?></td>
                      <td><?php echo isset($cliente->telefono) ? $cliente->telefono : 'N/A'; ?></td>
                      <td><?php echo isset($cliente->direccion) ? $cliente->direccion : 'N/A'; ?></td>
                      <td><?php echo $cliente->estado; ?></td>
                      <td>
                        <button class="btn btn-info view-details" data-id="<?php echo $cliente->id; ?>">
                          <i class="bi bi-eye"></i>
                        </button>
                        
                        <a href="<?php echo base_url('usuarios/editar/'.$cliente->id); ?>" class="btn btn-warning <?php echo ($this->session->userdata('rol') == 'empleado') ? 'disabled' : ''; ?>">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="#" class="btn btn-danger delete-user <?php echo ($this->session->userdata('rol') == 'empleado') ? 'disabled' : ''; ?>" data-id="<?php echo $cliente->id; ?>" data-name="<?php echo $cliente->nombre . ' ' . $cliente->apellido . ' ' . $cliente->segundo_apellido; ?>">
                            <i class="bi bi-trash"></i>
                        </a>

                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <tr>
                    <td colspan="8" class="text-center">No hay clientes registrados.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->

<!-- Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="userDetailsModalLabel">Detalles del Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Aquí se mostrarán los detalles del cliente -->
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-secondary btn-close-purple" data-bs-dismiss="modal" style="background-color: #6f42c1; border-color: #6f42c1; color: #ffffff;">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts adicionales -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-details');
    
    viewButtons.forEach(button => {
      button.addEventListener('click', function() {
        const userId = this.getAttribute('data-id');
        
        fetch(`<?php echo base_url('usuarios/ver_ajax/'); ?>${userId}`)
        .then(response => response.json())
        .then(data => {
          const modalBody = document.querySelector('#userDetailsModal .modal-body');
          modalBody.innerHTML = `
            <table class="table">
              <tr><th>Nombre:</th><td>${data.nombre}</td></tr>
              <tr><th>Apellido:</th><td>${data.apellido}</td></tr>
              <tr><th>Segundo Apellido:</th><td>${data.segundo_apellido ? data.segundo_apellido : 'N/A'}</td></tr>
              <tr><th>Email:</th><td>${data.email}</td></tr>
              <tr><th>Teléfono:</th><td>${data.telefono ? data.telefono : 'N/A'}</td></tr>
              <tr><th>Dirección:</th><td>${data.direccion ? data.direccion : 'N/A'}</td></tr>
              <tr><th>Fecha de Nacimiento:</th><td>${data.fecha_nacimiento ? data.fecha_nacimiento : 'N/A'}</td></tr>
              <tr><th>Fecha de Creación:</th><td>${data.fecha_creacion}</td></tr>
              <tr><th>Fecha de Actualización:</th><td>${data.fecha_actualizacion}</td></tr>
              <tr><th>Estado:</th><td>${data.estado}</td></tr>
              <tr><th>Usuario que realizó la última actualización:</th><td>${data.actualizador_nombre ? data.actualizador_nombre + ' ' + data.actualizador_apellido : 'N/A'}</td></tr>
            </table>
          `;
          const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
          modal.show();
        });

      });
    });

    const deleteButtons = document.querySelectorAll('.delete-user');
    
    deleteButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault();
        const userId = this.getAttribute('data-id');
        const userName = this.getAttribute('data-name');
        
        Swal.fire({
          title: '¿Estás seguro?',
          text: `Estás a punto de eliminar a ${userName}. ¡Esta acción no se puede deshacer!`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#6f42c1',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = `<?php echo base_url('usuarios/eliminar/'); ?>${userId}`;
          }
        });
      });
    });
  });
</script>
