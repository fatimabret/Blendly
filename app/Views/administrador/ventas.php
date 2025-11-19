        <h1 class="display-3 text-center text-white m-2 pb-2">Lista de Ventas</h1>

    </main>

    <div class="container-venta pt-3 pb-5">
        <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12"> 
        
            <!-- Buscador por fechas -->
            <form action="<?= base_url('ventas/buscar') ?>" method="get" class="row g-2 mb-4">
                <div class="col-md-5">
                    <label>Desde:</label>
                    <input type="date" name="desde" class="form-control" required>
                </div>

                <div class="col-md-5">
                    <label>Hasta:</label>
                    <input type="date" name="hasta" class="form-control" required>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" style="background: #1b243a;" class="btn btn-primary w-100 border -0">Buscar</button>
                </div>
            </form>
            
            <div class="table-responsive">
                <table id="mytable" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pedidos)): ?>
                            <?php 
                            $i = 1;
                            foreach($pedidos as $row): ?>
                                <tr>
                                    <td><?php echo $row['id_pedido']; ?></td>
                                    <td><?php echo $row['nombre_usuario']; ?></td>
                                    <td><?php echo $row['fecha_pedido']; ?></td>
                                    <td>$<?php echo number_format($row['total_venta'], 2); ?></td>
                                    <td><a href="<?php echo base_url('detalle_ventas/' . $row['id_pedido']); ?>" class="boton bt bnt m-auto p-2">Ver Detalle</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center alert alert-info" role="alert">No hay pedidos registrados!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
