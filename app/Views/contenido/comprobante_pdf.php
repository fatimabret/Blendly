<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        background: #ffffff;
        margin: 0;
        padding: 20px;
    }
    h2 { text-align: center; }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    th, td {
        border: 1px solid #000;
        padding: 6px;
        text-align: left;
    }
    .total {
        text-align: right;
        font-weight: bold;
        margin-top: 10px;
    }
</style>
</head>
<body>

<h2>Comprobante de Compra</h2>

<!-- DATOS DE LA TIENDA -->
<div class="alert alert-light border">
<strong>Blendly Bebidas</strong><br>
Email: blendly.drinks@example.com<br>
Dirección: 9 de Julio 1449, Corrientes Capital, Argentina
</div>

<hr>

<p>
<strong>Cliente:</strong> <?= esc($pedido['nombre_cliente']) ?><br>
<strong>DNI:</strong> <?= esc($pedido['dni_cliente']) ?><br>
<strong>Teléfono:</strong> <?= esc($pedido['telefono_cliente']) ?><br>
<strong>Método de pago:</strong> <?= esc($pedido['metodo_pago']) ?>
</p>

<table>
<thead>
<tr>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Precio</th>
    <th>Subtotal</th>
</tr>
</thead>
<tbody>
<?php foreach ($detalles as $d): ?>
<tr>
    <td><?= esc($d['producto']) ?></td>
    <td><?= esc($d['cantidad']) ?></td>
    <td>$<?= number_format($d['precio'], 2) ?></td>
    <td>$<?= number_format($d['cantidad'] * $d['precio'], 2) ?></td>
</tr>
<?php endforeach ?>
</tbody>
</table>

<p class="total">Total: $<?= number_format($total, 2) ?></p>

</body>
</html>
