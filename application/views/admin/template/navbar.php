<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="<?php echo base_url(); ?>" class="logo d-flex align-items-center">   
      <img src="<?= base_url('assets_admin/img/logo.png') ?>" alt="">
      <span class="d-none d-lg-block">3DPrintShop</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
      <input type="text" name="query" placeholder="Buscar" title="Ingresa palabra clave de búsqueda">
      <button type="submit" title="Buscar"><i class="bi bi-search"></i></button>
    </form>
  </div><!-- End Search Bar -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle" href="#">
          <i class="bi bi-search"></i>
        </a>
      </li><!-- End Search Icon -->

      <li class="nav-item dropdown">
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          <span class="badge bg-primary badge-number">4</span>
        </a><!-- End Notification Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header">
            Tienes 4 nuevas notificaciones
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Ver todas</span></a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-exclamation-circle text-warning"></i>
            <div>
              <h4>Lorem Ipsum</h4>
              <p>Quae dolorem earum veritatis oditseno</p>
              <p>Hace 30 min</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-x-circle text-danger"></i>
            <div>
              <h4>Atque rerum nesciunt</h4>
              <p>Quae dolorem earum veritatis oditseno</p>
              <p>Hace 1 hr</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-check-circle text-success"></i>
            <div>
              <h4>Sit rerum fuga</h4>
              <p>Quae dolorem earum veritatis oditseno</p>
              <p>Hace 2 hrs</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-info-circle text-primary"></i>
            <div>
              <h4>Dicta reprehenderit</h4>
              <p>Quae dolorem earum veritatis oditseno</p>
              <p>Hace 4 hrs</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>
          <li class="dropdown-footer">
            <a href="#">Mostrar todas las notificaciones</a>
          </li>

        </ul><!-- End Notification Dropdown Items -->

      </li><!-- End Notification Nav -->

      <li class="nav-item dropdown">
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-chat-left-text"></i>
          <span class="badge bg-success badge-number">3</span>
        </a><!-- End Messages Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
          <li class="dropdown-header">
            Tienes 3 nuevos mensajes
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Ver todos</span></a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="message-item">
            <a href="#">
              <img src="<?= base_url('assets_admin/img/messages-1.jpg') ?>" alt="" class="rounded-circle">
              <div>
                <h4>Maria Hudson</h4>
                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                <p>Hace 4 hrs</p>
              </div>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="message-item">
            <a href="#">
              <img src="<?= base_url('assets_admin/img/messages-2.jpg') ?>" alt="" class="rounded-circle">
              <div>
                <h4>Anna Nelson</h4>
                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                <p>Hace 6 hrs</p>
              </div>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="message-item">
            <a href="#">
              <img src="<?= base_url('assets_admin/img/messages-3.jpg') ?>" alt="" class="rounded-circle">
              <div>
                <h4>David Muldon</h4>
                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                <p>Hace 8 hrs</p>
              </div>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="dropdown-footer">
            <a href="#">Mostrar todos los mensajes</a>
          </li>

        </ul><!-- End Messages Dropdown Items -->

      </li><!-- End Messages Nav -->

      <li class="nav-item dropdown pe-3">
    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        
        <?php if ($this->session->userdata('imagen')): ?>
            <img src="<?= base_url($this->session->userdata('imagen')) ?>" alt="Profile" class="rounded-circle">
        <?php else: ?>
            <i class="bi bi-person-circle custom-nav-profile-icon"></i> <!-- Icono con clase personalizada -->
        <?php endif; ?>

        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido') ?></span>
    </a><!-- End Profile Image Icon -->

    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
    <li class="dropdown-header">
        <h6><?= $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido') ?></h6>
        <span><?= ucfirst($this->session->userdata('rol') ?: 'Rol no definido') ?></span>
    </li>


        <li>
            <hr class="dropdown-divider">
        </li>

        <li>
            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('perfil'); ?>">
                <i class="bi bi-person"></i>
                <span>Mi Perfil</span>
            </a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>

        <li>
            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('perfil'); ?>">
                <i class="bi bi-gear"></i>
                <span>Configuración de Cuenta</span>
            </a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>

        <li>
            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>¿Necesitas Ayuda?</span>
            </a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>

        <li>
            <a class="dropdown-item d-flex align-items-center" href="#" onclick="confirmLogout(event)">
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar Sesión</span>
            </a>
        </li>
    </ul><!-- End Profile Dropdown Items -->
</li><!-- End Profile Nav -->

<script>
function confirmLogout(event) {
    event.preventDefault();
    Swal.fire({
        title: '¿Estás seguro de cerrar la sesión?',
        text: "Si para cerrar, cancelar para volver",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar',
        customClass: {
            confirmButton: 'btn-green',
            cancelButton: 'btn-purple'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= base_url('auth/logout'); ?>';
        }
    });
}
</script>

  </nav><!-- End Icons Navigation -->

  <!-- Añade el bloque <style> aquí -->
  <style>
    /* Navbar hover effects */
    .header-nav .nav-link:hover,
    .header-nav .dropdown-item:hover {
      color: var(--accent-color) !important;
      background-color: var(--background-color) !important;
    }

    /* Dropdown menu hover effects */
    .header-nav .dropdown-menu .dropdown-item:hover {
      background-color: var(--background-color) !important;
      color: var(--accent-color) !important;
    }

    /* Header/Nav improvements */
    .header {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      background: var(--surface-color);
      padding: 10px 20px;
      transition: background 0.3s, box-shadow 0.3s;
    }

    .header:hover {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .header-nav .dropdown-menu {
      border-radius: 5px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s;
    }

    .header-nav .dropdown-menu:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .header-nav .dropdown-item {
      padding: 10px 15px;
      transition: background-color 0.3s, color 0.3s;
    }

    /* Notification and Messages hover effects */
    .header-nav .notifications .notification-item:hover,
    .header-nav .messages .message-item:hover {
      background-color: var(--background-color);
      border-left: 4px solid var(--accent-color);
    }

    .header-nav .notifications .notification-item,
    .header-nav .messages .message-item {
      transition: background-color 0.3s, border-left 0.3s;
    }

    /* Custom styles for SweetAlert2 buttons */
    .btn-green {
      background-color: #28a745 !important;
      color: white !important;
    }

    .btn-purple {
      background-color: #6f42c1 !important;
      color: white !important;
    }

    .btn-green:hover {
      background-color: #218838 !important;
    }

    .btn-purple:hover {
      background-color: #5a32a3 !important;
    }

    /* Ajustes personalizados para la imagen de perfil en el navbar */
    .header-nav .nav-profile img {
        width: 40px; /* Ajusta el ancho de la imagen */
        height: 40px; /* Ajusta la altura de la imagen */
        object-fit: cover; /* Asegura que la imagen se ajuste correctamente dentro del contenedor */
        border-radius: 50%; /* Mantiene la imagen circular */
    }

    /* Ajustes personalizados para el nombre del usuario en el navbar */
    .header-nav .nav-profile span {
        font-size: 14px; /* Ajusta el tamaño de la fuente */
        color: var(--heading-color); /* Ajusta el color del nombre del usuario */
    }

  span.d-none.d-lg-block:hover {
      color: #880fb8e5;
  }

</style>

</header><!-- End Header -->
