<main id="main" class="main">
  <div class="pagetitle">
    <h1 style="color: #28a745;">Perfil</h1> <!-- Título de perfil en verde -->
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>" style="color: #28a745;">Inicio</a></li> <!-- Inicio en verde -->
        <li class="breadcrumb-item">Usuarios</li>
        <li class="breadcrumb-item active">Perfil</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">
        <div class="card profile-card">
          <div class="card-body d-flex flex-column align-items-center">
          
          <?php if ($this->session->userdata('imagen')): ?>
              <img src="<?= base_url($this->session->userdata('imagen')) ?>" alt="Profile" class="rounded-circle">
          <?php else: ?>
              <i class="bi bi-person-circle custom-nav-profile-icon"></i> <!-- Icono con clase personalizada -->
          <?php endif; ?>

            <h2 class="profile-name"><?= $usuario->nombre . ' ' . $usuario->apellido?></h2>
            <h3 class="profile-role"><?= isset($usuario->rol) ? ucfirst($usuario->rol) : 'Rol no definido' ?></h3>
            <div class="social-links mt-2">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8">
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Resumen</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Perfil</button>
              </li>
            </ul>
            <div class="tab-content pt-2">
              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">Detalles del Perfil</h5>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Nombre Completo</div>
                  <div class="col-lg-9 col-md-8"><?= $usuario->nombre . ' ' . $usuario->apellido . ' ' . $usuario->segundo_apellido ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Correo Electrónico</div>
                  <div class="col-lg-9 col-md-8"><?= $usuario->email ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Teléfono</div>
                  <div class="col-lg-9 col-md-8"><?= $usuario->telefono ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Dirección</div>
                  <div class="col-lg-9 col-md-8"><?= $usuario->direccion ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Rol</div>
                  <div class="col-lg-9 col-md-8"><?= ucfirst($usuario->rol ?? ''); ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Edad</div>
                  <div class="col-lg-9 col-md-8"><?= $usuario->edad ?></div>
                </div>
              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <!-- Formulario de Editar Perfil -->
                <form class="row g-3 needs-validation" novalidate action="<?= base_url('perfil/actualizar'); ?>" method="post" enctype="multipart/form-data" id="editarPerfilFormCustom">
                  <input type="hidden" id="rol_usuario" value="<?= $usuario->rol?>">
                  <input type="hidden" name="email_original" value="<?= $usuario->email ?>">
                  
                  <div class="col-md-6">
                    <label for="nombre_custom" class="form-label">Nombre</label>
                    <input name="nombre" type="text" class="form-control uppercase" id="nombre_custom" value="<?= $usuario->nombre ?>" required pattern="[A-Za-z\s]+">
                    <div class="invalid-feedback">¡Por favor, ingrese un nombre válido sin números!</div>
                  </div>

                  <div class="col-md-6">
                    <label for="apellido_custom" class="form-label">Apellido</label>
                    <input name="apellido" type="text" class="form-control uppercase" id="apellido_custom" value="<?= $usuario->apellido ?>" required pattern="[A-Za-z\s]+">
                    <div class="invalid-feedback">¡Por favor, ingrese un apellido válido sin números!</div>
                  </div>

                  <div class="col-md-6">
                    <label for="segundo_apellido_custom" class="form-label">Segundo Apellido</label>
                    <input name="segundo_apellido" type="text" class="form-control uppercase" id="segundo_apellido_custom" value="<?= $usuario->segundo_apellido ?>" pattern="[A-Za-z\s]+">
                    <div class="invalid-feedback">¡Por favor, ingrese un segundo apellido válido sin números!</div>
                  </div>

                  <div class="col-md-6">
                      <label for="fecha_nacimiento_custom" class="form-label">Fecha de Nacimiento</label>
                      <input name="fecha_nacimiento" type="date" class="form-control" id="fecha_nacimiento_custom" value="<?= $usuario->fecha_nacimiento ?>" required>
                      <div class="invalid-feedback">¡Por favor, ingrese una fecha de nacimiento válida!</div>
                  </div>

                  <div class="col-md-6">
                    <label for="email_custom" class="form-label">Correo Electrónico</label>
                    <input name="email" type="email" class="form-control" id="email_custom" value="<?= $usuario->email ?>" required>
                    <div class="invalid-feedback">¡Por favor, ingrese una dirección de correo válida!</div>
                  </div>

                  <div class="col-md-6">
                    <label for="telefono_custom" class="form-label">Teléfono</label>
                    <input name="telefono" type="text" class="form-control cliente-optional" id="telefono_custom" value="<?= $usuario->telefono ?>" pattern="[0-9]{8,10}">
                    <div class="invalid-feedback">¡Por favor, ingrese un teléfono válido de 8 a 10 dígitos!</div>
                  </div>

                  <div class="col-12">
                    <label for="direccion_custom" class="form-label">Dirección</label>
                    <input name="direccion" type="text" class="form-control cliente-optional" id="direccion_custom" value="<?= $usuario->direccion ?>" required>
                    <div class="invalid-feedback">¡Por favor, ingrese la dirección!</div>
                  </div>

                  <div class="col-md-6">
                    <label for="current_password_custom" class="form-label">Contraseña Actual</label>
                    <input name="current_password" type="password" class="form-control" id="current_password_custom">
                    <div class="invalid-feedback">¡Por favor, ingrese su contraseña actual!</div>
                  </div>

                  <div class="col-md-6">
                    <label for="new_password_custom" class="form-label">Nueva Contraseña</label>
                    <input name="new_password" type="password" class="form-control" id="new_password_custom" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                    <div class="invalid-feedback">¡La contraseña debe tener al menos 8 caracteres, incluyendo una letra y un número!</div>
                  </div>

                  <div class="col-md-6">
                    <label for="confirm_password_custom" class="form-label">Confirmar Contraseña</label>
                    <input name="confirm_password" type="password" class="form-control" id="confirm_password_custom" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                    <div class="invalid-feedback">¡Las contraseñas no coinciden!</div>
                  </div>

                  <div class="col-md-12">
                    <label for="imagen_custom" class="form-label">Imagen de Perfil</label>
                    <input name="imagen" type="file" class="form-control" id="imagen_custom" accept="image/*">
                    <div class="invalid-feedback">¡Por favor, sube una imagen válida!</div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100" id="guardarCambiosBtnCustom">Guardar Cambios</button>
                  </div>
                </form><!-- End Profile Edit Form -->

                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                      const editarPerfilForm = document.getElementById('editarPerfilFormCustom');
                      const guardarCambiosBtn = document.getElementById('guardarCambiosBtnCustom');
                      const currentPasswordInput = document.getElementById('current_password_custom');
                      const newPasswordInput = document.getElementById('new_password_custom');
                      const confirmPasswordInput = document.getElementById('confirm_password_custom');
                      const telefonoInput = document.getElementById('telefono_custom');
                      const direccionInput = document.getElementById('direccion_custom');
                      const rolUsuario = document.getElementById('rol_usuario').value;

                      function validatePasswordsCustom() {
                          if (newPasswordInput.value !== confirmPasswordInput.value) {
                              confirmPasswordInput.setCustomValidity("Las contraseñas no coinciden");
                          } else {
                              confirmPasswordInput.setCustomValidity('');
                          }
                      }

                      function togglePasswordFieldsRequirementCustom() {
                          if (currentPasswordInput.value) {
                              newPasswordInput.setAttribute('required', 'required');
                              confirmPasswordInput.setAttribute('required', 'required');
                          } else {
                              newPasswordInput.removeAttribute('required');
                              confirmPasswordInput.removeAttribute('required');
                          }
                      }

                      function toggleContactFieldsRequirementCustom() {
                          if (rolUsuario === 'admin' || rolUsuario === 'empleado') {
                              telefonoInput.setAttribute('required', 'required');
                              direccionInput.setAttribute('required', 'required');
                          } else {
                              telefonoInput.removeAttribute('required');
                              direccionInput.removeAttribute('required');
                          }
                      }

                      newPasswordInput.addEventListener('input', validatePasswordsCustom);
                      confirmPasswordInput.addEventListener('input', validatePasswordsCustom);
                      currentPasswordInput.addEventListener('input', togglePasswordFieldsRequirementCustom);

                      toggleContactFieldsRequirementCustom();

                      editarPerfilForm.addEventListener('submit', function(event) {
                          const nombre = document.getElementById('nombre_custom');
                          const apellido = document.getElementById('apellido_custom');
                          nombre.value = nombre.value.toUpperCase();
                          apellido.value = apellido.value.toUpperCase();

                          validatePasswordsCustom();
                          togglePasswordFieldsRequirementCustom();

                          if (!editarPerfilForm.checkValidity()) {
                              event.preventDefault(); // Previene el envío del formulario si es inválido
                              event.stopPropagation();
                              editarPerfilForm.classList.add('was-validated');
                          } else {
                              guardarCambiosBtn.disabled = true; // Deshabilita el botón
                              guardarCambiosBtn.textContent = 'Guardando...'; // Cambia el texto del botón
                          }
                      });
                  });

                </script>

              </div>
            </div><!-- End Bordered Tabs -->
          </div>
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const editarPerfilForm = document.getElementById('editarPerfilFormCustom');
    const guardarCambiosBtn = document.getElementById('guardarCambiosBtnCustom');

    editarPerfilForm.addEventListener('submit', function(event) {
      if (!editarPerfilForm.checkValidity()) {
        event.preventDefault(); // Previene el envío del formulario si es inválido
        event.stopPropagation();
        editarPerfilForm.classList.add('was-validated');
      }
    });

    <?php if ($this->session->flashdata('success')): ?>
      Swal.fire({
        title: '¡Éxito!',
        text: '<?php echo $this->session->flashdata('success'); ?>',
        icon: 'success',
        confirmButtonText: 'OK'
      });
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
      Swal.fire({
        title: '¡Error!',
        text: '<?php echo $this->session->flashdata('error'); ?>',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    <?php endif; ?>
  });
</script>
