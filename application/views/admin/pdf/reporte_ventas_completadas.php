<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas Completadas</title>
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
            <h2>Reporte de Ventas Completadas</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Cliente</th>
                    <th>Fecha Venta</th>
                    <th>Productos</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td><?php echo $venta->id; ?></td>
                        <td><?php echo $venta->cliente_nombre . ' ' . $venta->cliente_apellido; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($venta->fecha_venta)); ?></td> <!-- Formato de fecha -->
                        <td>
                            <ul style="list-style-type: none; padding: 0;">
                                <?php foreach ($venta->productos as $producto): ?>
                                    <li><?php echo $producto->producto_nombre . ' (Cantidad: ' . $producto->cantidad . ')'; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td><?php echo '$' . number_format($venta->total, 2); ?></td> <!-- Formato de moneda -->
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
