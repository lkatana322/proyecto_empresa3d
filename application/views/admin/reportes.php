<main id="main" class="main">
  <div class="pagetitle">
    <h1 style="color: #28a745;">Generar Reportes</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item active">Generar Reportes</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="color: var(--default-color);">Reportes Disponibles</h5>

            <!-- Reportes de Ventas -->
            <!-- Reportes de Ventas -->
            <h6>Reportes de Ventas</h6>
            <form method="GET" action="<?php echo base_url('reportes/generar_pdf'); ?>" class="mb-3" target="_blank" id="formReporte">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="fecha_inicio_ventas" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio_ventas" name="fecha_inicio_ventas" required>
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_fin_ventas" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="fecha_fin_ventas" name="fecha_fin_ventas" required>
                    </div>
                </div>
                <button type="submit" name="reporte" value="ventas" class="btn btn-info">
                    <i class="bi bi-file-earmark-pdf"></i> Generar Reporte de Ventas (PDF)
                </button>
            </form>

            <!-- Reportes de Productos -->
            <h6>Reportes de Productos</h6>
            <form method="GET" action="<?php echo base_url('reportes/generar_pdf'); ?>" class="mb-3">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="producto" class="form-label">Producto</label>
                  <select id="producto" name="producto" class="form-select">
                    <option value="">Seleccione un Producto</option>
                    <?php foreach($productos as $producto): ?>
                      <option value="<?php echo $producto->id; ?>">
                        <?php echo $producto->nombre; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <button type="submit" name="reporte" value="productos" class="btn btn-info">
                <i class="bi bi-file-earmark-pdf"></i> Generar Reporte de Productos (PDF)
              </button>
            </form>

            <!-- Reportes de Clientes -->
            <h6>Reportes de Clientes</h6>
            <form method="GET" action="<?php echo base_url('reportes/generar_pdf'); ?>" class="mb-3">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="cliente" class="form-label">Cliente</label>
                  <select id="cliente" name="cliente" class="form-select">
                    <option value="">Seleccione un Cliente</option>
                    <?php foreach($clientes as $cliente): ?>
                      <option value="<?php echo $cliente->id; ?>">
                        <?php echo $cliente->nombre . ' ' . $cliente->apellido; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <button type="submit" name="reporte" value="clientes" class="btn btn-info">
                <i class="bi bi-file-earmark-pdf"></i> Generar Reporte de Clientes (PDF)
              </button>
            </form>

            <!-- Agregar más secciones para otros reportes -->
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
