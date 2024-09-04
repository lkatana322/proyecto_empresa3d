<main id="main" class="main">
  <div class="pagetitle">
    <h1 style="color: #28a745;">Agregar Categoría</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('categorias'); ?>">Gestión de Categorías</a></li>
        <li class="breadcrumb-item active">Agregar Categoría</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="color: var(--default-color);">Nueva Categoría</h5>

            <form action="<?php echo base_url('categorias/guardar'); ?>" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                <div class="row mb-3">
                    <label for="nombre_categoria" class="col-sm-3 col-form-label">Nombre</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" value="<?php echo set_value('nombre_categoria'); ?>" required pattern="^[A-Za-z0-9\s]+$">
                    <div class="invalid-feedback">¡Por favor, ingrese un nombre válido!</div>
                        <?php echo form_error('nombre_categoria'); ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="descripcion_categoria" class="col-sm-3 col-form-label">Descripción</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="descripcion_categoria" name="descripcion_categoria" required><?php echo set_value('descripcion_categoria'); ?></textarea>
                        <div class="invalid-feedback">¡Por favor, ingrese una descripción válida!</div>
                        <?php echo form_error('descripcion_categoria'); ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="estado_categoria" class="col-sm-3 col-form-label">Estado</label>
                    <div class="col-sm-9">
                        <select class="form-select" id="estado_categoria" name="estado_categoria" required>
                            <option value="activo" <?php echo set_select('estado_categoria', 'activo', TRUE); ?>>Activo</option>
                            <option value="inactivo" <?php echo set_select('estado_categoria', 'inactivo'); ?>>Inactivo</option>
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
                        <i class="fas fa-save"></i> Guardar
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
