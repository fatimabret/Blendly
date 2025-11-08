<div class="text p-2">
    <h4 class="text-end me-5">
        <a href="<?php echo base_url('productos'); ?>"
            class="botones btn btn-light custom-link m-auto d-inline-block me-3 p-2 pt-2">Continuar comprando</a>
    </h4>
</div>

<h1 class="display-3 text-center text-white m-2 pb-2">Carrito de Compras</h1>

</main>

<?php $cart = \Config\Services::cart(); ?>

<div class="container">
    <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
        <!--  Condicion para visualizar los errores de validacion  -->
        <?php if (session('mensaje')): ?>
        <div class="alert alert-light" role="alert">
            <?= session('mensaje') ?>
        </div>
        <?php endif; ?>

        <?php if ($cart->contents() == NULL) { ?>
        <h2 class="text-center alert alert-info" role="alert">Carrito Vacio!</h2>
        <?php } else { ?>

        <div class="table-responsive">
            <table id="mytable" class="table table-bordered table-striped table-hover custom-table formulario">

                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $total = 0;
                        $i = 1;
                        foreach ($cart->contents() as $item) {
                            $subtotal = $item['price'] * $item['qty'];
                            $total += $subtotal;
                        ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td>$<?php echo $item['price']; ?></td>
                        <td>
                            <form action="<?= base_url('actualizar_cantidad') ?>" method="post"
                                style="display:inline-flex; flex-direction:column; align-items:center;">
                                <input type="hidden" name="rowid" value="<?= $item['rowid']; ?>">
                                <button type="submit" name="accion" value="sumar"
                                    class="btn-cantidad btn-up">&#9650;</button>
                                <?= $item['qty']; ?>
                                <button type="submit" name="accion" value="restar"
                                    class="btn-cantidad btn-down">&#9660;</button>
                            </form>
                        </td>

                        <td>$<?php echo $subtotal; ?></td>
                        <td><a href="<?php echo base_url('quitar/' . $item['rowid']); ?>"
                                class="btn btn-danger">Eliminar</a></td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <td colspan="4" class="text-end"><strong>Total Compra:</strong></td>
                        <td colspan="2"><strong>$<?php echo $total; ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="3"><a href="<?php echo base_url('vaciar'); ?>" class="btn btn-warning">Vaciar
                                Carrito</a></td>
                        <td colspan="3"><a href="<?php echo base_url('guardar_venta'); ?>"
                                class="btn btn-success">Confirmar Compra</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
</div>