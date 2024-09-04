<main id="main" class="main">
  <div class="pagetitle">
    <h1 style="color: #28a745;">Editar Categoría</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('categorias'); ?>">Gestión de Categorías</a></li>
        <li class="breadcrumb-item active">Editar Categoría</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="color: var(--default-color);">Actualizar Categoría</h5>

            <form action="<?php echo base_url('categorias/actualizar'); ?>" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $categoria->id; ?>">

              <div class="row mb-3">
                  <label for="nombre_categoria" class="col-sm-3 col-form-label">Nombre</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" value="<?php echo set_value('nombre_categoria', $categoria->nombre); ?>" required pattern="^[A-Za-z0-9\s]+$">
                  <div class="invalid-feedback">¡Por favor, ingrese un nombre válido!</div>
                      <?php echo form_error('nombre_categoria'); ?>
                  </div>
              </div>

              <div class="row mb-3">
                  <label for="descripcion_categoria" class="col-sm-3 col-form-label">Descripción</label>
                  <div class="col-sm-9">
                      <textarea class="form-control" id="descripcion_categoria" name="descripcion_categoria" required><?php echo set_value('descripcion_categoria', $categoria->descripcion); ?></textarea>
                      <div class="invalid-feedback">¡Por favor, ingrese una descripción válida!</div>
                      <?php echo form_error('descripcion_categoria'); ?>
                  </div>
              </div>

              <div class="row mb-3">
                  <label for="estado_categoria" class="col-sm-3 col-form-label">Estado</label>
                  <div class="col-sm-9">
                      <select class="form-select" id="estado_categoria" name="estado_categoria" required>
                          <option value="activo" <?php echo set_select('estado_categoria', 'activo', $categoria->estado == 'activo'); ?>>Activo</option>
                          <option value="inactivo" <?php echo set_select('estado_categoria', 'inactivo', $categoria->estado == 'inactivo'); ?>>Inactivo</option>
                      </select>
                      <div class="invalid-feedback">¡Por favor, seleccione un estado!</div>
                  </div>
              </div>

              <div class="row mb-3">
                  <label for="imagen_categoria" class="col-sm-3 col-form-label">Imagen</label>
                  <div class="col-sm-9">
                      <input type="file" class="form-control" id="imagen_categoria" name="imagen_categoria">
                      <div class="invalid-feedback">¡Por favor, seleccione una imagen válida!</div>
                      <?php echo form_error('imagen_categoria'); ?>
                      <?php if (isset($categoria->imagen) && !empty($categoria->imagen)): ?>
                          <img src="<?php echo base_url($categoria->imagen); ?>" alt="<?php echo $categoria->nombre; ?>" style="width: 100px; height: 100px;">
                          <input type="hidden" name="imagen_actual" value="<?php echo $categoria->imagen; ?>">
                      <?php endif; ?>
                  </div>
              </div>

              <div class="text-center mt-4 d-flex justify-content-start">
                  <button type="submit" class="btn btn-success me-2">
                      <i class="fas fa-save"></i> Actualizar
                  </button>
                  <a href="<?php echo base_url('categorias'); ?>" class="btn btn-secondary">
                      <i class="fas fa-times"></i> Cancelar
                  </a>
              </div>
          </form>


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
