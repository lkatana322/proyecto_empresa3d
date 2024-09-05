<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Usuario</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('usuarios'); ?>">Gestión de Usuarios</a></li>
        <li class="breadcrumb-item active">Agregar Usuario</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Formulario de Agregar Usuario</h5>

            <!-- Formulario de Agregar Usuario -->
            <form class="row g-3 needs-validation" novalidate action="<?= base_url('usuarios/guardar') ?>" method="post" id="formAgregarUsuario">
              
              <div class="col-md-6">
                <label for="nombre_usuario" class="form-label">Nombre</label>
                <input type="text" name="nombre_usuario" class="form-control uppercase" id="nombre_usuario" required pattern="[A-Za-z\s]+">
                <div class="invalid-feedback">¡Por favor, ingrese un nombre válido sin números!</div>
              </div>

              <div class="col-md-6">
                <label for="apellido_usuario" class="form-label">Apellido</label>
                <input type="text" name="apellido_usuario" class="form-control uppercase" id="apellido_usuario" required pattern="[A-Za-z\s]+">
                <div class="invalid-feedback">¡Por favor, ingrese un apellido válido sin números!</div>
              </div>

              <div class="col-md-6">
                <label for="segundo_apellido_usuario" class="form-label">Segundo Apellido</label>
                <input type="text" name="segundo_apellido_usuario" class="form-control uppercase" id="segundo_apellido_usuario" pattern="[A-Za-z\s]+">
                <div class="invalid-feedback">¡Por favor, ingrese un segundo apellido válido sin números!</div>
              </div>

              <div class="col-md-6">
                  <label for="fecha_nacimiento_usuario" class="form-label">Fecha de Nacimiento</label>
                  <input type="date" name="fecha_nacimiento_usuario" class="form-control" id="fecha_nacimiento_usuario" required>
                  <div class="invalid-feedback">¡Por favor, ingrese una fecha de nacimiento válida!</div>
              </div>

              <div class="col-md-6">
                <label for="email_usuario" class="form-label">Correo Electrónico</label>
                <input type="email" name="email_usuario" class="form-control" id="email_usuario" required>
                <div class="invalid-feedback">¡Por favor, ingrese una dirección de correo válida!</div>
              </div>

              <div class="col-md-6">
                <label for="telefono_usuario" class="form-label">Teléfono</label>
                <input type="text" name="telefono_usuario" class="form-control" id="telefono_usuario" pattern="[0-9]{8,10}">
                <div class="invalid-feedback">¡Por favor, ingrese un teléfono válido de 8 a 10 dígitos!</div>
              </div>

              <div class="col-12">
                <label for="direccion_usuario" class="form-label">Dirección</label>
                <input type="text" name="direccion_usuario" class="form-control" id="direccion_usuario">
                <div class="invalid-feedback">¡Por favor, ingrese la dirección!</div>
              </div>

              <div class="col-md-6">
                  <label for="rol_usuario" class="form-label">Rol</label>
                  <select name="rol_usuario" class="form-select" id="rol_usuario" required>
                      <option value="" disabled selected>Seleccione un rol</option>
                      <option value="admin">Administrador</option>
                      <option value="empleado">Empleado</option>
                      <option value="cliente">Cliente</option>
                  </select>
                  <div class="invalid-feedback">¡Por favor, seleccione un rol!</div>
              </div>

              <div class="col-md-6" id="fechaContratacionWrapper" style="display:none;">
                <label for="fecha_contratacion_usuario" class="form-label">Fecha de Contratación</label>
                <input type="date" name="fecha_contratacion_usuario" class="form-control" id="fecha_contratacion_usuario">
                <div class="invalid-feedback">¡Por favor, ingrese la fecha de contratación!</div>
              </div>

              <div class="col-md-6">
                <label for="estado_usuario" class="form-label">Estado</label>
                <select name="estado_usuario" class="form-select" id="estado_usuario" required>
                  <option value="activo" selected>Activo</option>
                  <option value="inactivo">Inactivo</option>
                </select>
                <div class="invalid-feedback">¡Por favor, seleccione un estado!</div>
              </div>

              <div class="col-12 mt-4 d-flex justify-content-start">
                <button class="btn btn-success custom-btn me-2" type="submit" id="btnAgregarUsuario">
                    <i class="fas fa-user-plus"></i> Agregar Usuario
                </button>
                <a href="<?php echo base_url('usuarios'); ?>" class="btn btn-secondary custom-btn">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>

            </form>
            <!-- End Formulario de Agregar Usuario -->
             
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<style>

</style>