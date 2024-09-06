<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link " href="<?php echo base_url('admin'); ?>">
        <i class="bi bi-grid"></i>
        <span>Panel Principal</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person"></i><span>Gestión Usuarios</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?php echo base_url('usuarios'); ?>">
            <i class="bi bi-circle"></i><span>Ver Usuarios</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('usuarios/agregar'); ?>">
            <i class="bi bi-circle"></i><span>Agregar Usuario</span>
          </a>
        </li>
      </ul>
    </li><!-- End Gestión de Usuarios Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-briefcase"></i><span>Gestión Empleados</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?php echo base_url('usuarios/empleados'); ?>">
            <i class="bi bi-circle"></i><span>Ver Empleados</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('usuarios/agregar'); ?>">
            <i class="bi bi-circle"></i><span>Agregar Empleado</span>
          </a>
        </li>
      </ul>
    </li><!-- End Gestión de Empleados Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-people"></i><span>Gestión Clientes</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?php echo base_url('usuarios/clientes'); ?>">
            <i class="bi bi-circle"></i><span>Ver Clientes</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('usuarios/agregar'); ?>">
            <i class="bi bi-circle"></i><span>Agregar Cliente</span>
          </a>
        </li>
      </ul>
    </li><!-- End Gestión de Clientes Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-cart"></i><span>Gestión Ventas</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?php echo base_url('ventas'); ?>">
            <i class="bi bi-circle"></i><span>Ver Ventas</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('ventas/agregar'); ?>">
            <i class="bi bi-circle"></i><span>Agregar Venta</span>
          </a>
        </li>
      </ul>
    </li><!-- End Gestión de Ventas Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gem"></i><span>Gestión Productos</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?php echo base_url('productos'); ?>">
            <i class="bi bi-circle"></i><span>Ver Productos</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('productos/agregar'); ?>">
            <i class="bi bi-circle"></i><span>Agregar Producto</span>
          </a>
        </li>
      </ul>
    </li><!-- End Gestión de Productos Nav -->


    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#categories-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-tags"></i><span>Gestión Categorías</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="categories-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?php echo base_url('categorias'); ?>">
            <i class="bi bi-circle"></i><span>Ver Categorías</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('categorias/agregar'); ?>">
            <i class="bi bi-circle"></i><span>Agregar Categoría</span>
          </a>
        </li>
      </ul>
    </li><!-- End Gestión de Categorías Nav -->

    <!-- Reportes -->
    <li class="nav-heading">Reportes</li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="<?php echo base_url('reportes'); ?>">
        <i class="bi bi-file-earmark-bar-graph"></i>
        <span>Ver Reportes</span>
      </a>
    </li><!-- End Reportes Nav -->

    <!-- Profile -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url('perfil'); ?>">
        <i class="bi bi-person"></i>
        <span>Mi Perfil</span>
      </a>
    </li><!-- End Profile Nav -->

    <!-- Login -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="<?php echo base_url('auth/login'); ?>">
        <i class="bi bi-box-arrow-in-right"></i>
        <span>Iniciar Sesión</span>
      </a>
    </li><!-- End Login Nav -->

    <!-- Register -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="<?php echo base_url('usuarios/agregar'); ?>">
        <i class="bi bi-card-list"></i>
        <span>Registrar Usuario</span>
      </a>
    </li><!-- End Register Nav -->

  </ul>

</aside><!-- End Sidebar-->
