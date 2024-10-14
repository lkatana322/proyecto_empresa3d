<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Productos Más Vendidos</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .report {
            width: 100%;
            max-width: 600px; /* Limita el ancho máximo */
            margin: auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
        }
        .report-header {
            text-align: center;
            border-bottom: 3px solid #5fcf80;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .report-header h1 {
            margin: 0;
            font-size: 28px;
            color: #5fcf80;
        }
        .report-header h2 {
            font-size: 20px;
            margin: 10px 0;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #5fcf80;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="report">
        <div class="report-header">
            <h1 class="company-name">3DPrintShop</h1>
            <h2>Reporte de Productos Más Vendidos</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad Vendida</th>
                    <th>Ingresos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos_mas_vendidos as $producto): ?>
                    <tr>
                        <td><?php echo $producto->nombre; ?></td>
                        <td>$<?php echo number_format($producto->precio, 2); ?></td>
                        <td><?php echo $producto->cantidad_total; ?></td>
                        <td>$<?php echo number_format($producto->ingresos, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="footer">
            <p>Gracias por su confianza en 3DPrintShop.</p>
            <p>Para más información, contáctenos.</p>
        </div>
    </div>

</body>
</html>
