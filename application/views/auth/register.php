<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Registrar Cliente - 3DPrintShop</title>
  <meta name="description" content="Formulario de registro para nuevos clientes en 3DPrintShop">
  <meta name="keywords" content="registro, cliente, 3DPrintShop, impresión 3D">

  <!-- Favicons -->
  <link href="<?php echo base_url('assets_admin/img/favicon.png'); ?>" rel="icon">
  <link href="<?php echo base_url('assets_admin/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url('assets_admin/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets_admin/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets_admin/vendor/boxicons/css/boxicons.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets_admin/vendor/quill/quill.snow.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets_admin/vendor/remixicon/remixicon.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets_admin/vendor/simple-datatables/style.css'); ?>" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url('assets_admin/css/style.css'); ?>" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    /* Clases específicas para el logo */
    .logo-3dps-custom img {
      max-height: 25px;
      margin-right: 8px;
      border-radius: 4px;
    }

    .logo-3dps-custom span {
      font-size: 1.3rem;
      color: #5fcf80;
      font-weight: bold;
    }

    .logo-3dps-custom {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Clases específicas para el formulario */
    .custom-form-control {
      border-radius: 50px;
      padding: 10px 20px;
      text-transform: uppercase;
    }

    .custom-btn-primary {
      border-radius: 50px;
      padding: 10px 20px;
      background-color: #28a745;
      border-color: #28a745;
      font-size: 18px;
    }

    .custom-btn-primary:hover {
      background-color: #218838;
      border-color: #1e7e34;
    }

    .login-card-custom {
      max-width: 470px;
      width: 100%;
    }

    .custom-btn-blocked {
      background-color: #28a745 !important;
      cursor: not-allowed;
    }
  </style>
</head>

<body>
  <main>
    <div class="container">
      <section class="section register d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-4">
                <a href="<?php echo base_url(); ?>" class="logo-3dps-custom">
                  <img src="<?php echo base_url('assets_admin/img/logo.png'); ?>" alt="Logo 3DPrintShop">
                  <span class="d-none d-lg-block">3DPrintShop</span>
                </a>
              </div>

              <div class="card mb-3 login-card-custom shadow-sm">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Crear una Cuenta</h5>
                    <p class="text-center small">Llena los campos para crear una cuenta</p>
                  </div>

                  <!-- Mensajes de error y éxito -->
                  <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                      <?php echo $this->session->flashdata('error'); ?>
                    </div>
                  <?php endif; ?>

                  <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                      <?php echo $this->session->flashdata('success'); ?>
                    </div>
                  <?php endif; ?>

                  <!-- Formulario de registro -->
                  <form class="row g-3 needs-validation" action="<?php echo base_url('auth/register_action'); ?>" method="post" novalidate id="registerForm">
                    <div class="col-12">
                      <label for="nombre" class="form-label">Nombre</label>
                      <input type="text" name="nombre" class="form-control custom-form-control" id="nombre" required pattern="[A-Za-z\s]+">
                      <div class="invalid-feedback">Por favor, introduce tu nombre.</div>
                    </div>
                    <div class="col-12">
                      <label for="apellido" class="form-label">Apellido</label>
                      <input type="text" name="apellido" class="form-control custom-form-control" id="apellido" required pattern="[A-Za-z\s]+">
                      <div class="invalid-feedback">Por favor, introduce tu apellido.</div>
                    </div>
                    <div class="col-12">
                      <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                      <input type="text" name="segundo_apellido" class="form-control custom-form-control" id="segundo_apellido" pattern="[A-Za-z\s]+">
                      <div class="invalid-feedback">Por favor, introduce tu segundo apellido.</div>
                    </div>
                    <div class="col-12">
                      <label for="email" class="form-label">Correo Electrónico</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text custom-form-control" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="email" required>
                        <div class="invalid-feedback">Por favor, introduce tu correo electrónico.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="password" class="form-label">Contraseña</label>
                      <input type="password" name="password" class="form-control custom-form-control" id="password" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                      <div class="invalid-feedback">La contraseña debe tener al menos 8 caracteres, incluyendo una letra y un número.</div>
                    </div>
                    <div class="col-12">
                      <label for="password_confirm" class="form-label">Confirmar Contraseña</label>
                      <input type="password" name="password_confirm" class="form-control custom-form-control" id="password_confirm" required>
                      <div class="invalid-feedback">Por favor, confirma tu contraseña.</div>
                    </div>
                    <div class="col-12">
                      <button class="btn custom-btn-primary w-100" type="submit" id="registerBtn">Registrar</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">¿Ya tienes una cuenta? <a href="<?php echo base_url('auth/login'); ?>">Iniciar Sesión</a></p>
                    </div>
                  </form>

                  <!-- Script para mayúsculas y validación -->
                  <script>
                    document.addEventListener('DOMContentLoaded', function() {
                      const registerForm = document.getElementById('registerForm');
                      const registerBtn = document.getElementById('registerBtn');
                      const nombreInput = document.getElementById('nombre');
                      const apellidoInput = document.getElementById('apellido');

                      nombreInput.addEventListener('input', function() {
                        this.value = this.value.toUpperCase();
                      });

                      apellidoInput.addEventListener('input', function() {
                        this.value = this.value.toUpperCase();
                      });

                      registerForm.addEventListener('submit', function(event) {
                        if (!registerForm.checkValidity()) {
                          event.preventDefault();
                          event.stopPropagation();
                          registerForm.classList.add('was-validated');
                        } else {
                          registerBtn.disabled = true;
                          registerBtn.classList.add('custom-btn-blocked');
                          registerBtn.textContent = 'Registrando...';
                        }
                      }, false);
                    });
                  </script>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo base_url('assets_admin/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/apexcharts/apexcharts.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/chart.js/chart.umd.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/echarts/echarts.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/quill/quill.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/simple-datatables/simple-datatables.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/tinymce/tinymce.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/php-email-form/validate.js'); ?>"></script>

  <!-- Validación de contraseñas -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const passwordField = document.getElementById('password');
      const confirmPasswordField = document.getElementById('password_confirm');

      const validatePassword = () => {
        if (passwordField.value !== confirmPasswordField.value) {
          confirmPasswordField.setCustomValidity('Las contraseñas no coinciden');
          confirmPasswordField.classList.add('is-invalid');
        } else {
          confirmPasswordField.setCustomValidity('');
          confirmPasswordField.classList.remove('is-invalid');
        }
      };

      passwordField.addEventListener('input', validatePassword);
      confirmPasswordField.addEventListener('input', validatePassword);
    });
  </script>

</body>

</html>
