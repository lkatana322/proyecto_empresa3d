<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Confirmar Cuenta - 3DPrintShop</title>
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
    .custom-form-control {
      border-radius: 50px;
      padding: 10px 20px;
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
    .confirm-card {
      max-width: 470px;
      width: 100%;
      margin: 0 auto; /* Centramos la tarjeta */
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
                <a href="<?php echo base_url(); ?>" class="logo d-flex align-items-center w-auto">
                  <img src="<?php echo base_url('assets_admin/img/logo.png'); ?>" alt="">
                  <span class="d-none d-lg-block">3DPrintShop</span>
                </a>
              </div><!-- End Logo -->
              <div class="card mb-3 confirm-card shadow-sm">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Confirmar tu Cuenta</h5>
                    <p class="text-center small">Por favor, ingresa el código de confirmación que has recibido en tu correo electrónico.</p>
                  </div>
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
                  <form class="row g-3 needs-validation" action="<?php echo base_url('auth/confirmar_action'); ?>" method="post" novalidate>
                    <div class="col-12">
                      <label for="email" class="form-label">Correo Electrónico</label>
                      <input type="email" name="email" class="form-control custom-form-control" id="email" required>
                      <div class="invalid-feedback">Por favor, introduce tu correo electrónico.</div>
                    </div>
                    <div class="col-12">
                      <label for="codigo_confirmacion" class="form-label">Código de Confirmación</label>
                      <input type="text" name="codigo_confirmacion" class="form-control custom-form-control" id="codigo_confirmacion" required>
                      <div class="invalid-feedback">Por favor, introduce el código de confirmación.</div>
                    </div>
                    <div class="col-12">
                      <button class="btn custom-btn-primary w-100" type="submit">Confirmar Cuenta</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">¿No has recibido el código? <a href="<?php echo base_url('auth/reenviar_codigo'); ?>">Reenviar Código</a></p>
                    </div>
                  </form>
                </div>
              </div>
            </div>
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
  <!-- Custom JS File for Validation -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('.needs-validation');
      if (form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      }
    });
  </script>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const confirmForm = document.getElementById('confirmForm');
    const confirmBtn = document.getElementById('confirmBtn');

    confirmForm.addEventListener('submit', function(event) {
      if (!confirmForm.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      } else {
        confirmBtn.disabled = true;
        confirmBtn.classList.add('custom-btn-blocked');
        confirmBtn.textContent = 'Confirmando...';
      }
      confirmForm.classList.add('was-validated');
    }, false);
  });
</script>

</body>

</html>
