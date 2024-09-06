<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between logo-container">
    <a href="<?php echo base_url(); ?>" class="logo d-flex align-items-center">
      <img src="<?= base_url('assets_admin/img/logo.png') ?>" alt="Logo" class="logo-img">
      <span class="d-none d-lg-block logo-title">3DPrintShop</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>

  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
      <input type="text" name="query" placeholder="Buscar" title="Ingresa palabra clave de búsqueda" class="search-input">
      <button type="submit" title="Buscar" class="search-btn">
        <i class="bi bi-search"></i>
      </button>
    </form>
  </div>

  <nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">
    <li class="nav-item dropdown pe-3">
      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
        <img src="<?= base_url($this->session->userdata('imagen')) ?>" alt="Profile" class="rounded-circle profile-img" width="40" height="40">
        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido') ?></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile-menu">
        <li class="dropdown-header">
          <h6><?= $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido') ?></h6>
          <span><?= ucfirst($this->session->userdata('rol') ?: 'Rol no definido') ?></span>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item d-flex align-items-center" href="<?= base_url('perfil'); ?>"><i class="bi bi-person"></i>Mi Perfil</a></li>
        <li><a class="dropdown-item d-flex align-items-center" href="<?= base_url('perfil'); ?>"><i class="bi bi-gear"></i>Configuración de Cuenta</a></li>
        <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="bi bi-question-circle"></i>¿Necesitas Ayuda?</a></li>
        <li><a class="dropdown-item d-flex align-items-center" href="#" onclick="confirmLogout(event)"><i class="bi bi-box-arrow-right"></i>Cerrar Sesión</a></li>
      </ul>
    </li>
  </ul>
</nav>

</header>

<script>
function confirmLogout(event) {
  event.preventDefault();
  Swal.fire({
    title: '¿Estás seguro de cerrar la sesión?',
    text: "Si para cerrar, cancelar para volver",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#5fcf80',
    cancelButtonColor: '#880fb8e5',
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
