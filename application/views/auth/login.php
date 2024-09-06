<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Iniciar Sesión - 3DPrintShop</title>
  <meta name="description" content="Formulario de inicio de sesión para la plataforma 3DPrintShop">
  <meta name="keywords" content="3D Print, Iniciar Sesión, 3DPrintShop, Impresión 3D">

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
  <link href="<?php echo base_url('assets_admin/vendor/quill/quill.bubble.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets_admin/vendor/remixicon/remixicon.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets_admin/vendor/simple-datatables/style.css'); ?>" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url('assets_admin/css/style.css'); ?>" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    /* Estilos personalizados para el formulario de inicio de sesión */
    .login-card-3dps {
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 18px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 450px;
      padding: 20px;
      background-color: #ffffff;
    }

    .login-card-3dps .label-3dps {
      color: #19b954e0;
      font-weight: 600;
    }

    .login-card-3dps .input-group-text-3dps {
      background-color: #f8f9fa;
      border: none;
    }

    .login-card-3dps .input-field-3dps {
      border-radius: 50px;
      padding: 15px;
      border: 1px solid #ced4da;
      transition: border-color 0.3s ease;
    }

    .login-card-3dps .input-field-3dps:hover {
      border-color: #5fcf80;
    }

    .login-card-3dps .input-field-3dps:focus {
      border-color: #5fcf80;
      box-shadow: 0 0 0 0.2rem rgba(95, 207, 128, 0.25);
    }

    .login-card-3dps .btn-primary-3dps {
      background-color: #5fcf80;
      border: none;
      border-radius: 50px;
      padding: 10px 0;
      font-size: 1.2rem;
    }

    .login-card-3dps .btn-primary-3dps:hover {
      background-color: #4db96e;
    }

    .login-card-3dps .form-check-input-3dps:checked {
      background-color: #5fcf80;
      border-color: #5fcf80;
    }

    .login-card-3dps a {
      color: #5fcf80;
      text-decoration: none;
    }

    .login-card-3dps a:hover {
      color: #4db96e;
      text-decoration: underline;
    }
    
    /* Estilo del campo de Correo Electrónico */
    .input-group-3dps {
      display: flex;
      align-items: center;
      border-radius: 50px;
      overflow: hidden;
      border: 1px solid #ced4da;
      transition: border-color 0.3s ease;
    }

    .input-group-3dps:hover {
      border-color: #5fcf80;
    }

    .input-group-text-3dps {
      background-color: #f8f9fa;
      border: none;
      padding: 10px 20px;
      font-size: 1.2rem;
      color: #5fcf80; /* Color verde del icono "@" */
    }

    .input-field-3dps {
      border: none;
      border-radius: 0;
      padding: 15px;
      width: 100%;
      outline: none;
    }

    .login-card-3dps .input-group-3dps .input-field-3dps {
      border-top-right-radius: 50px;
      border-bottom-right-radius: 50px;
    }

    .container-3dps {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f4f6f9;
    }

    .title-3dps {
      color: #4b0082; /* Morado oscuro */
      font-size: 2rem;
      font-weight: bold;
      background: linear-gradient(45deg, #4b0082, #5fcf80);
      -webkit-background-clip: text;
      color: transparent; /* Efecto de gradiente en el texto */
    }

    .subtitle-3dps {
      font-size: 1rem;
      color: #6c757d; /* Gris suave */
      text-align: center;
      margin-bottom: 20px;
    }

    /* Logo personalizado */
    .logo-3dps img {
      max-height: 35px;
      margin-right: 10px;
    }

    .logo-3dps span {
      font-size: 1.5rem;
      color: #5fcf80;
      font-weight: bold;
    }

    /* Botón de regreso arriba */
    .back-to-top-3dps {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #5fcf80;
      color: white;
      border-radius: 50%;
      padding: 10px;
    }

    .back-to-top-3dps:hover {
      background-color: #4db96e;
    }
  </style>
</head>

<body>
  <main>
    <div class="container container-3dps">
      <section class="register d-flex flex-column align-items-center justify-content-center py-4">
        <div class="d-flex justify-content-center py-4">
          <a href="<?php echo base_url(); ?>" class="logo-3dps d-flex align-items-center w-auto">
            <img src="<?php echo base_url('assets_admin/img/logo.png'); ?>" alt="Logo 3DPrintShop">
            <span>3DPrintShop</span>
          </a>
        </div><!-- Fin del logo -->

        <div class="card login-card-3dps shadow-sm">
          <div class="card-body">
            <div class="pt-4 pb-2">
              <h5 class="card-title text-center pb-0 title-3dps">Iniciar Sesión en tu Cuenta</h5>
              <p class="text-center subtitle-3dps">Ingresa tu correo electrónico y contraseña para iniciar sesión</p>
            </div>

            <?php if ($this->session->flashdata('error')): ?>
              <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
              </div>
            <?php endif; ?>

            <form class="row g-3 needs-validation" action="<?php echo base_url('auth/login_action'); ?>" method="post" novalidate>
              <div class="col-12">
                <label for="yourUsername" class="form-label label-3dps">Correo Electrónico</label>
                <div class="input-group-3dps">
                  <span class="input-group-text-3dps">@</span>
                  <input type="email" name="email" class="form-control input-field-3dps" id="yourUsername" required>
                  <div class="invalid-feedback">Por favor, introduce tu correo electrónico.</div>
                </div>
              </div>

              <div class="col-12">
                <label for="yourPassword" class="form-label label-3dps">Contraseña</label>
                <input type="password" name="password" class="form-control input-field-3dps" id="yourPassword" required>
                <div class="invalid-feedback">Por favor, introduce tu contraseña.</div>
              </div>

              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input form-check-input-3dps" type="checkbox" name="remember" value="true" id="rememberMe">
                  <label class="form-check-label" for="rememberMe">Recuérdame</label>
                </div>
              </div>

              <div class="col-12">
                <button class="btn btn-primary-3dps w-100" type="submit">Iniciar Sesión</button>
              </div>

              <div class="col-12">
                <p class="small mb-0">¿No tienes una cuenta? <a href="<?php echo base_url('auth/register'); ?>">Crea una cuenta</a></p>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
  </main><!-- Fin del contenido principal -->

  <!-- Botón para volver arriba -->
  <a href="#" class="back-to-top-3dps d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo base_url('assets_admin/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/apexcharts/apexcharts.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/chart.js/chart.umd.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/echarts/echarts.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/quill/quill.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/simple-datatables/simple-datatables.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/tinymce/tinymce.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/php-email-form/validate.js'); ?>"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo base_url('assets_admin/js/main.js'); ?>"></script>
</body>

</html>
