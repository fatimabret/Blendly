<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">

        <style>
            .header {
                width: 100%;
                margin-bottom: 10px;
            }
            body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 12px;
                background: #ffffff;
                margin: 0;
                padding: 0;
            }

            /* CONTENEDOR CENTRADO */
            .comprobante {
                width: 80%;
                max-width: 520px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
            }

            h2 {
                text-align: center;
                margin-bottom: 10px;
                font-size: 18px;
            }

            .empresa {
                text-align: center;
                font-size: 11px;
                margin-bottom: 15px;
                font-size: 11px;
                vertical-align: middle;
            }

            hr {
                border: none;
                border-top: 1px solid #ccc;
                margin: 12px 0;
            }

            .datos-cliente p {
                margin: 4px 0;
                font-size: 11px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
                font-size: 11px;
            }

            th {
                background: #f2f2f2;
                text-align: left;
                padding: 6px;
                border-bottom: 1px solid #999;
            }

            td {
                padding: 6px;
                border-bottom: 1px solid #ddd;
            }

            .text-right {
                text-align: right;
            }

            .total {
                text-align: right;
                font-size: 13px;
                font-weight: bold;
                margin-top: 12px;
            }
            
            .info-table {
                width: 100%;
                margin-top: 15px;
            }

            .info-table td {
                vertical-align: top;
                padding: 10px;
            }

            .col-izq {
                width: 55%;
            }

            .col-der {
                width: 45%;
                border-left: 1px solid #ccc;
                padding-left: 15px;
            }

            h4 {
                margin-bottom: 6px;
                font-size: 13px;
                border-bottom: 1px solid #ccc;
                padding-bottom: 4px;
            }

            .footer {
                text-align: center;
                font-size: 10px;
                margin-top: 20px;
                color: #555;
            }
        </style>
    </head>

    <body>

        <div class="comprobante">

            <h2>Comprobante de Compra</h2>

            <!-- ENCABEZADO CON LOGO -->
            <table class="header">
                <td class="empresa">
                    <strong>Blendly Bebidas</strong><br>
                        Email: blendly.drinks@example.com<br>
                        9 de Julio 1449, Corrientes Capital, Argentina
                </td>
            </table>

            <hr>

            <table class="info-table">
                <tr>
                    <!-- DATOS DEL CLIENTE -->
                    <td class="col-izq">
                        <h4>Datos del Cliente</h4>
                        <p><strong>Cliente:</strong> <?= esc($pedido['nombre_cliente']) ?></p>
                        <p><strong>DNI:</strong> <?= esc($pedido['dni_cliente']) ?></p>
                        <p><strong>Teléfono:</strong> <?= esc($pedido['telefono_cliente']) ?></p>
                        <p><strong>Método de pago:</strong> <?= esc($pedido['metodo_pago']) ?></p>
                        <p><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($pedido['fecha_pedido'])) ?></p>
                    </td>

                    <!-- DATOS DEL ENVIO/RETIRO -->
                    <td class="col-der">
                        <h4>Forma de Entrega</h4>
                        <?php if (!empty($direccion)): ?>
                            <p><strong>Tipo:</strong> Envío a domicilio</p>
                            <p><?= esc($direccion['calle']) ?> <?= esc($direccion['numero']) ?><br>
                                <?= esc($direccion['ciudad']) ?>, <?= esc($direccion['provincia']) ?><br>
                                CP: <?= esc($direccion['cp']) ?></p>
                        <?php else: ?>
                            <p><strong>Tipo:</strong> Retiro en sucursal</p>
                            <p>Dirección: 9 de Julio 1449<br>
                                Corrientes Capital</p>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <hr>

            <!-- DETALLE -->
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="text-right">Cant.</th>
                        <th class="text-right">Precio</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $d): ?>
                        <tr>
                            <td><?= esc($d['producto']) ?></td>
                            <td class="text-right"><?= esc($d['cantidad']) ?></td>
                            <td class="text-right">$<?= number_format($d['precio'], 2) ?></td>
                            <td class="text-right">$<?= number_format($d['cantidad'] * $d['precio'], 2) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <p class="total">Total: $<?= number_format($total, 2) ?></p>

            <div class="footer">
                Gracias por su compra<br>
                Este comprobante no es válido como factura
            </div>

        </div>

    </body>
</html>
