<style>
body {
    background-color: #f8f9fa; /* Fondo claro */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Fuente moderna */
    margin: 0; /* Sin margen por defecto */
    padding: 20px; /* Padding general */
    line-height: 1.6; /* Aumentar el espaciado entre líneas */
}

.main {
    padding: 20px;
}

.pagetitle h1 {
    color: #5fcf80; /* Color del título */
    margin-bottom: 15px; /* Espacio inferior */
    font-size: 2em; /* Tamaño de fuente más grande para el título */
}

.card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); /* Sombra más prominente para las tarjetas */
    background-color: #ffffff; /* Fondo blanco para la tarjeta */
    padding: 20px; /* Padding interno */
    margin-bottom: 20px; /* Espacio entre tarjetas */
}

.card-title {
    color: #5fcf80; /* Color del título de la tarjeta */
    font-weight: bold; /* Negrita */
    font-size: 1.5em; /* Tamaño de fuente más grande para el título de la tarjeta */
}

h6 {
    color: #333; /* Color de los subtítulos */
    margin-top: 20px; /* Espacio superior */
    margin-bottom: 10px; /* Espacio inferior */
    font-size: 1.2em; /* Tamaño de fuente más grande para los subtítulos */
    font-weight: 600; /* Negrita */
}

.form-control {
    border-radius: 4px; /* Bordes redondeados */
    border: 1px solid #ccc; /* Borde gris claro */
    transition: border-color 0.3s; /* Efecto de transición */
    font-size: 1em; /* Tamaño de fuente para los inputs */
}

.form-control:focus {
    border-color: #5fcf80; /* Color del borde al enfocarse */
    box-shadow: 0 0 5px rgba(95, 207, 128, 0.5); /* Sombra al enfocarse */
}

.btn-info {
    background-color: #17a2b8; /* Color original del botón */
    border: none; /* Sin borde */
    border-radius: 4px; /* Bordes redondeados */
    padding: 10px 20px; /* Padding interno para botones */
    font-weight: bold; /* Negrita en el texto del botón */
    transition: background-color 0.3s, transform 0.2s; /* Efecto de transición */
    color: #fff; /* Color del texto en blanco */
    font-size: 1em; /* Tamaño de fuente para el texto del botón */
}

.btn-info:hover {
    background-color: #138496; /* Color más oscuro al pasar el ratón */
    transform: translateY(-2px); /* Efecto de elevar el botón al pasar el ratón */
    color: #5fcf80; /* Cambia el color del texto al pasar el ratón */
}

.row {
    margin-bottom: 20px; /* Espacio inferior entre filas */
}

.form-group {
    margin-bottom: 15px; /* Espacio inferior para el grupo de formularios */
}

/* Estilo para el botón de retroceso */
.btn-back {
    background-color: #17a2b8; /* Color gris del botón de retroceso */
    margin-top: 20px; /* Espacio superior */
}

.btn-back:hover {
    background-color: #5fcf80; /* Color más oscuro al pasar el ratón */
}
</style>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Generar Reportes</h1>
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
            <h5 class="card-title">Reportes Disponibles</h5>

            <h6>Reportes de Ventas Completadas</h6>
            <form method="GET" action="<?php echo base_url('reportes/generar_pdf_ventas_completadas'); ?>" class="mb-3" target="_blank">
                <button type="submit" name="reporte" value="ventas_completadas" class="btn btn-info">
                    <i class="bi bi-file-earmark-pdf"></i> Generar Reporte de Ventas Completadas (PDF)
                </button>
            </form>

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
                    <i class="bi bi-file-earmark-pdf"></i> Generar Reporte de Ventas por Fechas (PDF)
                </button>
            </form>

            <!-- Reporte de Clientes Más Fieles -->
            <h6>Reporte de Clientes Más Fieles</h6>
            <form method="GET" action="<?php echo base_url('reportes/generar_reporte_clientes_mas_fieles'); ?>" class="mb-3" target="_blank" id="formReporteClientesMasFieles">
                <div class="form-group">
                    <label for="limite">Número de clientes más fieles:</label>
                    <input type="number" name="limite" id="limite" class="form-control" min="1" placeholder="Introduce el número" value="10" required style="width: 120px; display: inline-block;">
                </div>
                <button type="submit" name="reporte" value="clientes_mas_fieles" class="btn btn-info mt-3">
                    <i class="bi bi-file-earmark-pdf"></i> Generar Reporte de Clientes Más Fieles (PDF)
                </button>
            </form>

            <!-- Reporte de Productos Más Vendidos -->
            <h6>Reporte de Productos Más Vendidos</h6>
            <form method="GET" action="<?php echo base_url('reportes/generar_reporte_productos_mas_vendidos'); ?>" class="mb-3" target="_blank" id="formReporteProductosMasVendidos">
                <button type="submit" name="reporte" value="productos_mas_vendidos" class="btn btn-info">
                    <i class="bi bi-file-earmark-pdf"></i> Generar Reporte de Productos Más Vendidos (PDF)
                </button>
            </form>

            <!-- Botón de retroceso -->
            <a href="<?php echo base_url('admin'); ?>" class="btn btn-back">
                <i class="bi bi-arrow-left"></i> Volver
            </a>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
