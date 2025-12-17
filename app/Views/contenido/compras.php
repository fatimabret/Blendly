
        <h1 class="display-3 text-center text-white m-2 pb-2">Mis Compras</h1>

    </main>

    <div class="container-venta pt-3 pb-5">
        <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
            <div class="table-responsive">
                <?php if (!empty($compras)): ?>
                    <table id="mytable" class="table table-bordered table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 1;
                            foreach($compras as $row) { ?>
                                <tr>
                                    <td><?php echo $row['id_pedido']; ?></td>
                                    <td><?php echo $row['fecha_pedido']; ?></td>
                                    <td>$<?php echo number_format($row['total_venta'], 2); ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('detalle_compra/' . $row['id_pedido']); ?>" class="btn btn-primary btn-sm mb-1">Ver detalle</a>
                                        <a href="<?= base_url('ver_comprobante/' . $row['id_pedido']); ?>" class="btn btn-success btn-sm" target="_blank">Ver comprobante</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                <?php else: ?>
                    <h2 class="text-center alert alert-info" role="alert">No hay pedidos registrados!</h2>
                <?php endif; ?>
            </div>
        </div>
    </div>
