<main id="main" class="main">
  <div class="pagetitle">
    <h1 style="color: #28a745;">Gestión de Categorías</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item active">Gestión de Categorías</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="color: var(--default-color);">Categorías</h5>

            <a href="<?php echo base_url('categorias/agregar'); ?>" class="btn btn-primary add-category-btn">
                <i class="bi bi-plus-circle"></i> Agregar Categoría
            </a>
            
            <a href="<?php echo base_url('categorias/inactivas'); ?>" class="btn btn-secondary">
                <i class="bi bi-eye-slash"></i> Ver Categorías Inactivas
            </a>

            <table class="table">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Fecha de Creación</th>
                    <th>Fecha de Actualización</th>
                    <th>Usuario que Actualizó</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($categorias)) : ?>
                    <?php foreach($categorias as $categoria): ?>
                        <tr>
                        <td>
                            <?php if (!empty($categoria->imagen)): ?>
                                <img src="<?php echo base_url($categoria->imagen); ?>" alt="<?php echo $categoria->nombre; ?>" style="width: 60px; height: 60px;">
                            <?php else: ?>
                                <img src="<?php echo base_url('assets_admin/categorias/default.png'); ?>" alt="Sin Imagen" style="width: 50px; height: 50px;">
                            <?php endif; ?>
                        </td>
                            <td><?php echo $categoria->nombre; ?></td>
                            <td><?php echo $categoria->descripcion; ?></td>
                            <td><?php echo $categoria->estado; ?></td>
                            <td><?php echo $categoria->fecha_creacion; ?></td>
                            <td><?php echo $categoria->fecha_actualizacion; ?></td>
                            <td><?php echo isset($categoria->actualizador_nombre) ? $categoria->actualizador_nombre . ' ' . $categoria->actualizador_apellido : 'N/A'; ?></td>
                            <td>
                                <button class="btn btn-info view-details" data-id="<?php echo $categoria->id; ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a href="<?php echo base_url('categorias/editar/'.$categoria->id); ?>" class="btn btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="#" class="btn btn-danger delete-category" data-id="<?php echo $categoria->id; ?>" data-name="<?php echo $categoria->nombre; ?>">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">No hay categorías registradas.</td>
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
<div class="modal fade" id="categoryDetailsModal" tabindex="-1" aria-labelledby="categoryDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="categoryDetailsModalLabel">Detalles de la Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Aquí se mostrarán los detalles de la categoría -->
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
        const categoryId = this.getAttribute('data-id');
        
        fetch(`<?php echo base_url('categorias/ver_ajax/'); ?>${categoryId}`)
        .then(response => response.json())
        .then(data => {
          const modalBody = document.querySelector('#categoryDetailsModal .modal-body');
          modalBody.innerHTML = `
            <table class="table">
              <tr><th>Nombre:</th><td>${data.nombre}</td></tr>
              <tr><th>Descripción:</th><td>${data.descripcion}</td></tr>
              <tr><th>Estado:</th><td>${data.estado}</td></tr>
              <tr><th>Fecha de Creación:</th><td>${data.fecha_creacion}</td></tr>
              <tr><th>Fecha de Actualización:</th><td>${data.fecha_actualizacion}</td></tr>
              <tr><th>Usuario que realizó la última actualización:</th><td>${data.actualizador_nombre ? data.actualizador_nombre + ' ' + data.actualizador_apellido : 'N/A'}</td></tr>
            </table>
          `;
          const modal = new bootstrap.Modal(document.getElementById('categoryDetailsModal'));
          modal.show();
        });

      });
    });

    const deleteButtons = document.querySelectorAll('.delete-category');
    
    deleteButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault();
        const categoryId = this.getAttribute('data-id');
        const categoryName = this.getAttribute('data-name');
        
        Swal.fire({
          title: '¿Estás seguro?',
          text: `Estás a punto de eliminar la categoría ${categoryName}. ¡Esta acción no se puede deshacer!`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#6f42c1',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = `<?php echo base_url('categorias/eliminar/'); ?>${categoryId}`;
          }
        });
      });
    });
  });
</script>
