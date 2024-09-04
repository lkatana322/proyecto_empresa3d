<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Iniciar Sesión - 3DPrintShop</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url('assets_admin/img/favicon.png'); ?>" rel="icon">
  <link href="<?php echo base_url('assets_admin/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

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
    /* Custom Styles for Login Form */
    .login-card-custom {
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 18px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 450px; /* Ajuste del ancho */
      padding: 20px;
    }

    .login-card-custom .form-label {
      color: #19b954e0;
      font-weight: 600;
    }

    .login-card-custom .input-group-text {
      background-color: #f8f9fa;
      border: none;
    }

    .login-card-custom .form-control {
      border-radius: 50px;
      padding: 15px;
      border: 1px solid #ced4da;
    }

    .login-card-custom .form-control:focus {
      border-color: #5fcf80;
      box-shadow: 0 0 0 0.2rem rgba(95, 207, 128, 0.25);
    }

    .login-card-custom .btn-primary {
      background-color: #5fcf80;
      border: none;
      border-radius: 50px;
      padding: 10px 0;
    }

    .login-card-custom .btn-primary:hover {
      background-color: #4db96e;
    }

    .login-card-custom .form-check-input:checked {
      background-color: #5fcf80;
      border-color: #5fcf80;
    }

    .login-card-custom a {
      color: #5fcf80;
    }

    .login-card-custom a:hover {
      color: #4db96e;
      text-decoration: underline;
    }

    .login-card-custom .input-group {
      display: flex;
      align-items: center;
    }

    .login-card-custom .input-group-text {
      border-top-left-radius: 50px;
      border-bottom-left-radius: 50px;
    }

    .login-card-custom .form-control {
      border-top-right-radius: 50px;
      border-bottom-right-radius: 50px;
    }

    .custom-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f4f6f9;
    }

    .custom-title {
      color: #4b0082; /* Morado oscuro */
    }
  </style>
</head>

<body>
  <main>
    <div class="container custom-container">
      <section class="register d-flex flex-column align-items-center justify-content-center py-4">
        <div class="d-flex justify-content-center py-4">
          <a href="<?php echo base_url(); ?>" class="logo d-flex align-items-center w-auto">
            <img src="<?php echo base_url('assets_admin/img/logo.png'); ?>" alt="">
            <span class="d-none d-lg-block">3DPrintShop</span>
          </a>
        </div><!-- End Logo -->
        <div class="card login-card-custom shadow-sm">
          <div class="card-body">
            <div class="pt-4 pb-2">
              <h5 class="card-title text-center pb-0 fs-4 custom-title">Iniciar Sesión en tu Cuenta</h5>
              <p class="text-center small">Ingresa tu correo electrónico y contraseña para iniciar sesión</p>
            </div>
            <?php if ($this->session->flashdata('error')): ?>
              <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
              </div>
            <?php endif; ?>
            <form class="row g-3 needs-validation" action="<?php echo base_url('auth/login_action'); ?>" method="post" novalidate>
              <div class="col-12">
                <label for="yourUsername" class="form-label">Correo Electrónico</label>
                <div class="input-group has-validation">
                  <span class="input-group-text" id="inputGroupPrepend">@</span>
                  <input type="text" name="email" class="form-control" id="yourUsername" required>
                  <div class="invalid-feedback">Por favor, introduce tu correo electrónico.</div>
                </div>
              </div>
              <div class="col-12">
                <label for="yourPassword" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" id="yourPassword" required>
                <div class="invalid-feedback">Por favor, introduce tu contraseña!</div>
              </div>
              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                  <label class="form-check-label" for="rememberMe">Recuérdame</label>
                </div>
              </div>
              <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">Iniciar Sesión</button>
              </div>
              <div class="col-12">
                <p class="small mb-0">¿No tienes una cuenta? <a href="<?php echo base_url('auth/register'); ?>">Crea una cuenta</a></p>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo base_url('assets_admin/vendor/apexcharts/apexcharts.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets_admin/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
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
