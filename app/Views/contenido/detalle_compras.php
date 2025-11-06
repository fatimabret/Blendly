        <h1 class="display-3 text-center text-white m-2 pb-2">Detalles de Mi Compra</h1>

        <div class="container text-end">
            <a href="<?php echo base_url('mi_compra');?>"class="boton bt bnt m-auto p-2"><img src="<?php echo base_url('assets/img/icons/back.png');?>" alt="" width="25" height="25">Volver</a>
        </div>
    </main>

    <div class="container-detalle pt-3 pb-5">
        <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
            <div class="table-responsive">
                <?php if (!empty($compra_detalles)): ?>
                    <table id="mytable" class="table table-bordered table-striped table-hover formulario">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 1;
                            $total = 0;
                            foreach($compra_detalles as $detalle) {
                                $subtotal = $detalle['precio_unitario'] * $detalle['cantidad_pedido'];
                                $total += $subtotal;
                            ?>
                                <tr>
                                    <td><?php echo $detalle['nombre_producto']; ?></td>
                                    <td><?php echo $detalle['descripcion_producto']; ?></td>
                                    <td><?php echo $detalle['cantidad_pedido']; ?></td>
                                    <td>$<?php echo number_format($detalle['precio_unitario'], 2); ?></td>
                                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                <td>$<strong><?php echo number_format($total, 2); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                <?php else: ?>
                    <h2 class="text-center alert alert-info" role="alert">No hay detalles de venta registrados!</h2>
                <?php endif; ?>
            </div>

        </div>
    </div>
