<!-- ======= Main ======= -->
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Panel Principal</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Inicio</a></li>
        <li class="breadcrumb-item active">Panel Principal</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row">

<!-- Sales Card -->
<!-- Vistas comunes como header, navbar, sidebar, etc. -->
<!-- Ventas Card -->
    <div class="container">
      <div class="row">
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card" data-type="ventas">
                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filtrar</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Hoy</a></li>
                        <li><a class="dropdown-item" href="#">Este Mes</a></li>
                        <li><a class="dropdown-item" href="#">Este Año</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Ventas <span id="ventas-subtitle">| HOY</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="ventas-count"><?php echo isset($ventas_hoy) ? $ventas_hoy : 0; ?></h6>
                            <span id="ventas-percentage" class="text-success small pt-1 fw-bold">0%</span> <span class="text-muted small pt-2 ps-1">aumento</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ingresos Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card" data-type="ingresos">
                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filtrar</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Hoy</a></li>
                        <li><a class="dropdown-item" href="#">Este Mes</a></li>
                        <li><a class="dropdown-item" href="#">Este Año</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Ingresos <span id="ingresos-subtitle">| HOY</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="ps-3">
                          <h6 id="ingresos-count">
                              <?php echo isset($ingresos_hoy) ? "$" . number_format($ingresos_hoy, 2) : "$0.00"; ?>
                          </h6>
                          <span id="ingresos-percentage" class="text-success small pt-1 fw-bold">0%</span> <span class="text-muted small pt-2 ps-1">aumento</span>
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clientes Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card customers-card" data-type="clientes">
                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filtrar</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Hoy</a></li>
                        <li><a class="dropdown-item" href="#">Este Mes</a></li>
                        <li><a class="dropdown-item" href="#">Este Año</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Clientes <span id="clientes-subtitle">| HOY</span>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                          <h6 id="clientes-count"><?php echo isset($clientes_hoy) ? $clientes_hoy : 0; ?></h6>
                          <span class="text-muted small pt-2 ps-1">aumento</span>
                      </div>
                    </div>
                </div>
            </div>
         </div>
      </div>
  </div>

<!-- Script AJAX para actualizar las tarjetas -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    function updateCard(data, cardType, filterOption) {
        const countElement = $('#' + cardType + '-count');
        const percentageElement = $('#' + cardType + '-percentage');
        const subtitleElement = $('#' + cardType + '-subtitle');

        if (cardType === 'ingresos') {
            countElement.text(data.count ? '$' + parseFloat(data.count).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '$0.00');
        } else {
            countElement.text(data.count);
            percentageElement.text(data.percentage + '%');
        }

        if (data.percentage < 0) {
            percentageElement.removeClass('text-success').addClass('text-danger');
        } else {
            percentageElement.removeClass('text-danger').addClass('text-success');
        }

        // Actualizar el subtítulo de la tarjeta
        subtitleElement.text('| ' + filterOption.replace("_", " ").toUpperCase());
    }

    // Función para formatear números con comas
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Cargar datos iniciales
    const initialFilters = ['hoy', 'hoy', 'hoy'];
    const cardTypes = ['ventas', 'ingresos', 'clientes'];
    
    cardTypes.forEach(function(cardType, index) {
        $.ajax({
            url: '<?php echo base_url('ventas/filtrar_datos'); ?>',
            type: 'POST',
            data: {
                filterOption: initialFilters[index],
                cardType: cardType
            },
            success: function(response) {
                const data = JSON.parse(response);
                updateCard(data, cardType, initialFilters[index]);
            }
        });
    });

  $('.info-card .dropdown-item').on('click', function(e) {
      e.preventDefault();

        const filterOption = $(this).text().toLowerCase().replace(" ", "_");
        const cardType = $(this).closest('.info-card').data('type');

        $.ajax({
            url: '<?php echo base_url('ventas/filtrar_datos'); ?>',
            type: 'POST',
            data: {
                filterOption: filterOption,
                cardType: cardType
            },
            success: function(response) {
                const data = JSON.parse(response);
                updateCard(data, cardType, filterOption);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
});

</script>

          <!-- Reports -->
          <div class="col-12">
            <div class="card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filtrar</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Hoy</a></li>
                  <li><a class="dropdown-item" href="#">Este Mes</a></li>
                  <li><a class="dropdown-item" href="#">Este Año</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Reportes <span>/Hoy</span></h5>

                <!-- Line Chart -->
                <div id="reportsChart"></div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#reportsChart"), {
                      series: [{
                        name: 'Ventas',
                        data: [31, 40, 28, 51, 42, 82, 56],
                      }, {
                        name: 'Ingresos',
                        data: [11, 32, 45, 32, 34, 52, 41]
                      }, {
                        name: 'Clientes',
                        data: [15, 11, 32, 18, 9, 24, 11]
                      }],
                      chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                          show: false
                        },
                      },
                      markers: {
                        size: 4
                      },
                      colors: ['#4154f1', '#2eca6a', '#ff771d'],
                      fill: {
                        type: "gradient",
                        gradient: {
                          shadeIntensity: 1,
                          opacityFrom: 0.3,
                          opacityTo: 0.4,
                          stops: [0, 90, 100]
                        }
                      },
                      dataLabels: {
                        enabled: false
                      },
                      stroke: {
                        curve: 'smooth',
                        width: 2
                      },
                      xaxis: {
                        type: 'datetime',
                        categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                      },
                      tooltip: {
                        x: {
                          format: 'dd/MM/yy HH:mm'
                        },
                      }
                    }).render();
                  });
                </script>
                <!-- End Line Chart -->

              </div>

            </div>
          </div><!-- End Reports -->

<!-- Recent Sales -->
<div class="col-12">
    <div class="card recent-sales overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Ventas Recientes</h5>

            <table class="table table-borderless datatable">
                <thead>
                    <tr>
                        <th scope="col">Cliente</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio Unitario</th>
                        <th scope="col">Total</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($ventas) && !empty($ventas)): ?>
                        <?php foreach(array_slice($ventas, 0, 5) as $venta): ?>
                            <?php foreach($venta->productos as $producto): ?>
                                <tr>
                                    <td>
                                        <?php echo !empty($venta->cliente_nombre) ? $venta->cliente_nombre . ' ' . $venta->cliente_apellido : 'Cliente no definido'; ?>
                                    </td>
                                    <td>
                                        <?php echo $producto->producto_nombre; ?>
                                    </td>
                                    <td>
                                        <?php echo $producto->cantidad; ?>
                                    </td>
                                    <td>
                                        <?php echo "$" . number_format($producto->precio_unitario, 2); ?>
                                    </td>
                                    <td>
                                        <?php echo "$" . number_format($producto->cantidad * $producto->precio_unitario, 2); ?>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            <?php 
                                                switch($venta->estado) {
                                                    case 'completada':
                                                        echo 'bg-success';
                                                        break;
                                                    case 'pendiente':
                                                        echo 'bg-warning';
                                                        break;
                                                    case 'cancelada':
                                                        echo 'bg-danger';
                                                        break;
                                                    default:
                                                        echo 'bg-secondary';
                                                }
                                            ?>">
                                            <?php echo ucfirst($venta->estado); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No hay ventas recientes</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Recent Sales -->

<!-- Top Selling -->
<div class="col-12">
    <div class="card top-selling overflow-auto">

        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filtrar</h6>
                </li>
                <li><a class="dropdown-item" href="#">Hoy</a></li>
                <li><a class="dropdown-item" href="#">Este Mes</a></li>
                <li><a class="dropdown-item" href="#">Este Año</a></li>
            </ul>
        </div>

        <div class="card-body pb-0">
            <h5 class="card-title">Más Vendidos <span>| Hoy</span></h5>

            <table class="table table-borderless">
              <thead>
                  <tr>
                      <th scope="col">Vista Previa</th>
                      <th scope="col">Producto</th>
                      <th scope="col">Precio</th>
                      <th scope="col">Vendidos</th>
                      <th scope="col">Ingresos</th>
                  </tr>
              </thead>
              <tbody>
                  <?php if(isset($top_selling_products) && !empty($top_selling_products)): ?>
                      <?php foreach($top_selling_products as $product): ?>
                          <tr>
                              <th scope="row">
                                  <a href="#"><img src="<?php echo base_url($product->imagen); ?>" alt="" style="width: 50px; height: auto;"></a>
                              </th>
                              <td><a href="#" class="text-primary fw-bold"><?php echo $product->producto_nombre; ?></a></td>
                              <td>$<?php echo number_format($product->precio, 2); ?></td>
                              <td class="fw-bold"><?php echo $product->cantidad_vendida; ?></td>
                              <td>$<?php echo number_format($product->ingresos, 2); ?></td>
                          </tr>
                      <?php endforeach; ?>
                  <?php else: ?>
                      <tr>
                          <td colspan="5">No hay productos vendidos.</td>
                      </tr>
                  <?php endif; ?>
              </tbody>
          </table>

        </div>

    </div>
</div><!-- End Top Selling -->



        </div>
      </div><!-- End Left side columns -->

      <!-- Right side columns -->
      <div class="col-lg-4">

<!-- Recent Activity -->
<div class="card">
    <div class="filter">
        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
                <h6>Filtrar</h6>
            </li>
            <li><a class="dropdown-item" href="#">Hoy</a></li>
            <li><a class="dropdown-item" href="#">Este Mes</a></li>
            <li><a class="dropdown-item" href="#">Este Año</a></li>
        </ul>
    </div>

    <div class="card-body">
        <h5 class="card-title">Actividad Reciente <span>| Hoy</span></h5>

        <div class="activity">
          <?php if (isset($actividades) && !empty($actividades)) : ?>
              <?php foreach ($actividades as $actividad) : ?>
                  <div class="activity-item d-flex">
                      <div class="activite-label"><?php echo date('d M, H:i', strtotime($actividad->fecha_hora)); ?></div>
                      <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                      <div class="activity-content">
                          <?php echo ucfirst($actividad->accion); ?> - <?php echo $actividad->descripcion; ?>
                          <br>
                          <small>Por: <?php echo strtoupper($actividad->usuario_nombre . ' ' . $actividad->usuario_apellido); ?></small>
                      </div>
                  </div><!-- End activity item-->
              <?php endforeach; ?>
          <?php else : ?>
              <div class="activity-item d-flex">
                  <div class="activity-content">
                      No hay actividades recientes
                  </div>
              </div><!-- End activity item-->
          <?php endif; ?>
      </div>
    </div>
</div><!-- End Recent Activity -->

        <!-- Budget Report -->
        <div class="card">
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>Filtrar</h6>
              </li>

              <li><a class="dropdown-item" href="#">Hoy</a></li>
              <li><a class="dropdown-item" href="#">Este Mes</a></li>
              <li><a class="dropdown-item" href="#">Este Año</a></li>
            </ul>
          </div>

          <div class="card-body pb-0">
            <h5 class="card-title">Informe de Presupuesto <span>| Este Mes</span></h5>

            <div id="budgetChart" style="min-height: 400px;" class="echart"></div>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
                  legend: {
                    data: ['Presupuesto Asignado', 'Gasto Real']
                  },
                  radar: {
                    // shape: 'circle',
                    indicator: [{
                        name: 'Ventas',
                        max: 6500
                      },
                      {
                        name: 'Administración',
                        max: 16000
                      },
                      {
                        name: 'Tecnología de la Información',
                        max: 30000
                      },
                      {
                        name: 'Soporte al Cliente',
                        max: 38000
                      },
                      {
                        name: 'Desarrollo',
                        max: 52000
                      },
                      {
                        name: 'Marketing',
                        max: 25000
                      }
                    ]
                  },
                  series: [{
                    name: 'Presupuesto vs Gasto',
                    type: 'radar',
                    data: [{
                        value: [4200, 3000, 20000, 35000, 50000, 18000],
                        name: 'Presupuesto Asignado'
                      },
                      {
                        value: [5000, 14000, 28000, 26000, 42000, 21000],
                        name: 'Gasto Real'
                      }
                    ]
                  }]
                });
              });
            </script>

          </div>
        </div><!-- End Budget Report -->

        <!-- Website Traffic -->
        <div class="card">
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>Filtrar</h6>
              </li>

              <li><a class="dropdown-item" href="#">Hoy</a></li>
              <li><a class="dropdown-item" href="#">Este Mes</a></li>
              <li><a class="dropdown-item" href="#">Este Año</a></li>
            </ul>
          </div>

          <div class="card-body pb-0">
            <h5 class="card-title">Tráfico del Sitio Web <span>| Hoy</span></h5>

            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                echarts.init(document.querySelector("#trafficChart")).setOption({
                  tooltip: {
                    trigger: 'item'
                  },
                  legend: {
                    top: '5%',
                    left: 'center'
                  },
                  series: [{
                    name: 'Acceso Desde',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
                    label: {
                      show: false,
                      position: 'center'
                    },
                    emphasis: {
                      label: {
                        show: true,
                        fontSize: '18',
                        fontWeight: 'bold'
                      }
                    },
                    labelLine: {
                      show: false
                    },
                    data: [{
                        value: 1048,
                        name: 'Motor de Búsqueda'
                      },
                      {
                        value: 735,
                        name: 'Directo'
                      },
                      {
                        value: 580,
                        name: 'Correo Electrónico'
                      },
                      {
                        value: 484,
                        name: 'Anuncios de Unión'
                      },
                      {
                        value: 300,
                        name: 'Anuncios de Video'
                      }
                    ]
                  }]
                });
              });
            </script>

          </div>
        </div><!-- End Website Traffic -->

        <!-- News & Updates Traffic -->
        <div class="card">
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>Filtrar</h6>
              </li>

              <li><a class="dropdown-item" href="#">Hoy</a></li>
              <li><a class="dropdown-item" href="#">Este Mes</a></li>
              <li><a class="dropdown-item" href="#">Este Año</a></li>
            </ul>
          </div>

          <div class="card-body pb-0">
            <h5 class="card-title">Noticias y Actualizaciones <span>| Hoy</span></h5>

            <div class="news">
              <div class="post-item clearfix">
                <img src="<?php echo base_url('assets_admin/img/news-1.jpg'); ?>" alt="">
                <h4><a href="#">Nuevo Modelo de Impresora 3D Lanzado</a></h4>
                <p>Nuestro nuevo modelo de impresora 3D es más rápido y eficiente...</p>
              </div>

              <div class="post-item clearfix">
                <img src="<?php echo base_url('assets_admin/img/news-2.jpg'); ?>" alt="">
                <h4><a href="#">Historia de Éxito de un Cliente</a></h4>
                <p>Lee cómo nuestro cliente utilizó con éxito nuestros servicios de impresión 3D...</p>
              </div>

              <div class="post-item clearfix">
                <img src="<?php echo base_url('assets_admin/img/news-3.jpg'); ?>" alt="">
                <h4><a href="#">Consejos para Mejorar la Impresión 3D</a></h4>
                <p>Aprende algunas técnicas avanzadas para obtener lo mejor de tus impresiones 3D...</p>
              </div>

              <div class="post-item clearfix">
                <img src="<?php echo base_url('assets_admin/img/news-4.jpg'); ?>" alt="">
                <h4><a href="#">Próximo Taller de Impresión 3D</a></h4>
                <p>Únete a nuestro taller para aprender sobre las últimas tendencias en impresión 3D...</p>
              </div>

              <div class="post-item clearfix">
                <img src="<?php echo base_url('assets_admin/img/news-5.jpg'); ?>" alt="">
                <h4><a href="#">Cómo Elegir el Filamento Correcto</a></h4>
                <p>Diferentes filamentos para diferentes necesidades. Aprende cuál es el adecuado para ti...</p>
              </div>

            </div><!-- End sidebar recent posts-->

          </div>
        </div><!-- End News & Updates -->

      </div><!-- End Right side columns -->

    </div>
  </section>

</main><!-- End #main -->
