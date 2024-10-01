<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .invoice {
            width: 100%;
            max-width: 600px;
            margin: auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            padding: 30px;
            position: relative;
        }
        .invoice-header {
            text-align: center;
            border-bottom: 3px solid #5fcf80; /* Color del título */
            padding-bottom: 20px;
        }
        .invoice-header h1 {
            margin: 0;
            font-size: 32px;
            color: #5fcf80; /* Color del título */
        }
        .logo {
            margin-bottom: 15px;
        }
        .logo img {
            max-width: 80px; /* Ajusta el tamaño del logo */
        }
        .invoice-details {
            margin: 20px 0;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        .invoice-details p {
            margin: 4px 0;
            font-size: 14px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        th {
            background-color: #5fcf80; /* Color del encabezado de la tabla */
            color: white;
        }
        .total-row {
            font-weight: bold;
            background-color: #e6f9e6;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .footer p {
            margin: 5px 0;
        }
        .watermark {
            position: absolute;
            top: 10%;
            left: 10%;
            opacity: 0.1;
            font-size: 80px;
            color: #5fcf80;
            transform: rotate(-30deg);
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="watermark">3DPrintShop</div>
        <div class="invoice-header">
            <div class="logo">
                <img src="<?= base_url('assets_admin/img/logo.png') ?>" alt="Logo">
            </div>
            <h1>3DPrintShop</h1>
            <h2>Ticket de Venta</h2>
            <p>Número de venta: <?php echo $venta->id; ?></p>
        </div>
        <div class="invoice-details">
            <p><strong>Cliente:</strong> <?php echo $venta->cliente_nombre . ' ' . $venta->cliente_apellido; ?></p>
            <p><strong>Vendedor:</strong> <?php echo $venta->usuario_nombre . ' ' . $venta->usuario_apellido; ?></p>
            <p><strong>Fecha de Venta:</strong> <?php echo $venta->fecha_venta; ?></p>
        </div>
        <h2>Productos Vendidos</h2>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($venta->detalles) && is_array($venta->detalles)): ?>
                    <?php 
                        $total = 0; // Inicializa el total
                        foreach ($venta->detalles as $detalle): 
                        $subtotal = $detalle->cantidad * $detalle->precio_unitario;
                        $total += $subtotal; // Suma al total
                    ?>
                        <tr>
                            <td><?php echo $detalle->producto_nombre; ?></td>
                            <td><?php echo $detalle->cantidad; ?></td>
                            <td><?php echo number_format($detalle->precio_unitario, 2); ?> </td>
                            <td><?php echo number_format($subtotal, 2); ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Total:</td>
                        <td><?php echo number_format($total, 2); ?> </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay productos disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="footer">
            <p>Gracias por su compra.</p>
            <p>Para cualquier consulta, contáctenos.</p>
        </div>
    </div>
</body>
</html>
