<main id="main" class="main">
  <div class="pagetitle">
    <h1 style="color: #28a745;">Gestión de Productos Inactivos</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item active">Gestión de Productos Inactivos</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="color: var(--default-color);">Productos Inactivos</h5>

            <a href="<?php echo base_url('productos'); ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver a Productos Activos
            </a>

            <table class="table">
              <thead>
                <tr>
                  <th>Imagen</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Precio</th>
                  <th>Cantidad</th>
                  <th>Categoría</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($productos)) : ?>
                    <?php foreach($productos as $producto): ?>
                        <tr>
                            <td><img src="<?php echo base_url($producto->imagen); ?>" style="width: 60px; height: 60px;"></td>
                            <td><?php echo $producto->nombre; ?></td>
                            <td><?php echo $producto->descripcion; ?></td>
                            <td><?php echo $producto->precio; ?></td>
                            <td><?php echo $producto->stock; ?></td>
                            <td><?php echo $producto->categoria_nombre; ?></td>
                            <td><?php echo $producto->estado; ?></td>
                            <td>
                                <button class="btn btn-info view-details" data-id="<?php echo $producto->id; ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a href="<?php echo base_url('productos/editar/'.$producto->id); ?>" class="btn btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="#" class="btn btn-danger delete-product" data-id="<?php echo $producto->id; ?>" data-name="<?php echo $producto->nombre; ?>">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">No hay productos inactivos registrados.</td>
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

<!-- Scripts adicionales -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-details');
    
    viewButtons.forEach(button => {
      button.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        
        fetch(`<?php echo base_url('productos/ver_ajax/'); ?>${productId}`)
        .then(response => response.json())
        .then(data => {
          const modalBody = document.querySelector('#productDetailsModal .modal-body');
          modalBody.innerHTML = `
            <table class="table">
              <tr><th>Nombre:</th><td>${data.nombre}</td></tr>
              <tr><th>Descripción:</th><td>${data.descripcion}</td></tr>
              <tr><th>Precio:</th><td>${data.precio}</td></tr>
              <tr><th>Stock:</th><td>${data.stock}</td></tr>
              <tr><th>Categoría:</th><td>${data.categoria_nombre}</td></tr>
              <tr><th>Estado:</th><td>${data.estado}</td></tr>
              <tr><th>Fecha de Creación:</th><td>${data.fecha_creacion}</td></tr>
              <tr><th>Fecha de Actualización:</th><td>${data.fecha_actualizacion}</td></tr>
              <tr><th>Usuario que realizó la última actualización:</th><td>${data.actualizador_nombre ? data.actualizador_nombre + ' ' + data.actualizador_apellido : 'N/A'}</td></tr>
            </table>
          `;
          const modal = new bootstrap.Modal(document.getElementById('productDetailsModal'));
          modal.show();
        });

      });
    });

    const deleteButtons = document.querySelectorAll('.delete-product');
    
    deleteButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault();
        const productId = this.getAttribute('data-id');
        const productName = this.getAttribute('data-name');
        
        Swal.fire({
          title: '¿Estás seguro?',
          text: `Estás a punto de eliminar el producto ${productName}. ¡Esta acción no se puede deshacer!`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#6f42c1',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = `<?php echo base_url('productos/eliminar/'); ?>${productId}`;
          }
        });
      });
    });
  });
</script>
