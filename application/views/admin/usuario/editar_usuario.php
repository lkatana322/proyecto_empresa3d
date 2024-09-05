<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar Usuario</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('usuarios'); ?>">Gestión de Usuarios</a></li>
        <li class="breadcrumb-item active">Editar Usuario</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-10">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Formulario de Editar Usuario</h5>
            <form action="<?php echo base_url('usuarios/actualizar'); ?>" method="post" class="needs-validation" novalidate id="editarUsuarioForm">
              <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
              
              <div class="row mb-3">
                <label for="nombre_usuario" class="col-md-4 col-form-label">Nombre:</label>
                <div class="col-md-8">
                  <input type="text" class="form-control uppercase" id="nombre_usuario" name="nombre_usuario" value="<?php echo $usuario->nombre; ?>" required pattern="[A-Za-z\s]+">
                  <div class="invalid-feedback">¡Por favor, ingrese un nombre válido sin números!</div>
                </div>
              </div>

              <div class="row mb-3">
                <label for="apellido_usuario" class="col-md-4 col-form-label">Apellido:</label>
                <div class="col-md-8">
                  <input type="text" class="form-control uppercase" id="apellido_usuario" name="apellido_usuario" value="<?php echo $usuario->apellido; ?>" required pattern="[A-Za-z\s]+">
                  <div class="invalid-feedback">¡Por favor, ingrese un apellido válido sin números!</div>
                </div>
              </div>

              <div class="row mb-3">
                <label for="segundo_apellido_usuario" class="col-md-4 col-form-label">Segundo Apellido:</label>
                <div class="col-md-8">
                  <input type="text" class="form-control uppercase" id="segundo_apellido_usuario" name="segundo_apellido_usuario" value="<?php echo $usuario->segundo_apellido; ?>" pattern="[A-Za-z\s]+">
                  <div class="invalid-feedback">¡Por favor, ingrese un segundo apellido válido sin números!</div>
                </div>
              </div>

              <div class="row mb-3">
                  <label for="fecha_nacimiento_usuario" class="col-md-4 col-form-label">Fecha de Nacimiento:</label>
                  <div class="col-md-8">
                      <input type="date" class="form-control" id="fecha_nacimiento_usuario" name="fecha_nacimiento_usuario" value="<?php echo isset($usuario->fecha_nacimiento) ? $usuario->fecha_nacimiento : ''; ?>">
                      <div class="invalid-feedback">¡Por favor, ingrese una fecha de nacimiento válida!</div>
                  </div>
              </div>

              <div class="row mb-3">
                <label for="email_usuario" class="col-md-4 col-form-label">Email:</label>
                <div class="col-md-8">
                  <input type="email" class="form-control" id="email_usuario" name="email_usuario" value="<?php echo $usuario->email; ?>" required>
                  <div class="invalid-feedback">¡Por favor, ingrese una dirección de correo válida!</div>
                </div>
              </div>

              <div class="row mb-3">
                <label for="rol_usuario" class="col-md-4 col-form-label">Rol:</label>
                <div class="col-md-8">
                    <select class="form-control" id="rol_usuario" name="rol_usuario" required>
                        <option value="admin" <?php if($usuario->rol == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="empleado" <?php if($usuario->rol == 'empleado') echo 'selected'; ?>>Empleado</option>
                        <option value="cliente" <?php if($usuario->rol == 'cliente') echo 'selected'; ?>>Cliente</option>
                    </select>
                    <div class="invalid-feedback">¡Por favor, seleccione un rol!</div>
                </div>
              </div>


              <div id="fecha_contratacion_group" class="row mb-3" style="display: none;">
                  <label for="fecha_contratacion_usuario" class="col-md-4 col-form-label">Fecha de Contratación:</label>
                  <div class="col-md-8">
                      <input type="date" class="form-control" id="fecha_contratacion_usuario" name="fecha_contratacion_usuario" value="<?php echo isset($usuario->fecha_contratacion) ? $usuario->fecha_contratacion : ''; ?>">
                  </div>
              </div>

              <div class="row mb-3">
                <label for="telefono_usuario" class="col-md-4 col-form-label">Teléfono:</label>
                <div class="col-md-8">
                  <input type="text" class="form-control cliente-optional" id="telefono_usuario" name="telefono_usuario" value="<?php echo $usuario->telefono; ?>" pattern="[0-9]{8,10}">
                  <div class="invalid-feedback">¡Por favor, ingrese un teléfono válido de 8 a 10 dígitos!</div>
                </div>
              </div>

              <div class="row mb-3">
                <label for="direccion_usuario" class="col-md-4 col-form-label">Dirección:</label>
                <div class="col-md-8">
                  <input type="text" class="form-control cliente-optional" id="direccion_usuario" name="direccion_usuario" value="<?php echo $usuario->direccion; ?>">
                  <div class="invalid-feedback">¡Por favor, ingrese la dirección!</div>
                </div>
              </div>

              <div class="row mb-3">
                <label for="estado_usuario" class="col-md-4 col-form-label">Estado:</label>
                <div class="col-md-8">
                  <select class="form-control" id="estado_usuario" name="estado_usuario" required>
                    <option value="activo" <?php if($usuario->estado == 'activo') echo 'selected'; ?>>Activo</option>
                    <option value="inactivo" <?php if($usuario->estado == 'inactivo') echo 'selected'; ?>>Inactivo</option>
                  </select>
                  <div class="invalid-feedback">¡Por favor, seleccione un estado!</div>
                </div>
              </div>

              <div class="col-md-12 mt-4">
                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Actualizar</button>
                <a href="<?php echo base_url('usuarios'); ?>" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancelar</a>
              </div>

            </form>

            <script>
              document.addEventListener('DOMContentLoaded', function() {
                const editarUsuarioForm = document.getElementById('editarUsuarioForm');
                const actualizarUsuarioBtn = document.getElementById('actualizarUsuarioBtn');
                const rolSelect = document.getElementById('rol_usuario');
                const fechaContratacionGroup = document.getElementById('fecha_contratacion_group');

                // Mostrar/Ocultar el campo "Fecha de Contratación" basado en el rol seleccionado

                function toggleFechaContratacion() {
                    const selectedRole = rolSelect.value;
                    if (selectedRole === 'admin' || selectedRole === 'empleado') {
                        fechaContratacionGroup.style.display = 'flex'; // Mostrar el campo
                    } else {
                        fechaContratacionGroup.style.display = 'none'; // Ocultar el campo
                        document.getElementById('fecha_contratacion_usuario').value = ''; // Limpiar el valor
                    }
                }
                // Ejecutar la función al cargar la página
                toggleFechaContratacion();

                // Escuchar cambios en el select de rol
                rolSelect.addEventListener('change', toggleFechaContratacion);

                editarUsuarioForm.addEventListener('submit', function(event) {
                  if (!editarUsuarioForm.checkValidity()) {
                    event.preventDefault(); // Previene el envío del formulario si es inválido
                    event.stopPropagation();
                    editarUsuarioForm.classList.add('was-validated');
                  } else {
                    actualizarUsuarioBtn.disabled = true; // Deshabilita el botón
                    actualizarUsuarioBtn.textContent = 'Actualizando...'; // Cambia el texto del botón
                  }
                });
              });
            </script>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
