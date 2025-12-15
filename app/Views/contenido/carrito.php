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
                        <td colspan="3">
                            <a href="<?php echo base_url('vaciar'); ?>" class="btn btn-warning">Vaciar
                                Carrito</a>
                        </td>
                        <td colspan="3">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalConfirmarCompra"> Continuar Compra</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>

    <!--  Cargamos los modales  -->
    <?= view('contenido/modal_confirmar_compra') ?>
    <?= view('contenido/modal_resumen_compra') ?>

    <script>
        function mostrarResumen() {

            const f = document.querySelector('#modalConfirmarCompra form');

            // SPANS resumen
            const res_nombre   = document.getElementById('res_nombre');
            const res_telefono = document.getElementById('res_telefono');
            const res_dni      = document.getElementById('res_dni');
            const res_entrega  = document.getElementById('res_entrega');

            // INPUTS ocultos
            const inp_nombre   = document.getElementById('inp_nombre');
            const inp_telefono = document.getElementById('inp_telefono');
            const inp_dni      = document.getElementById('inp_dni');
            const inp_metodo   = document.getElementById('inp_metodo');

            const inp_calle     = document.getElementById('inp_calle');
            const inp_numero    = document.getElementById('inp_numero');
            const inp_piso      = document.getElementById('inp_piso');
            const inp_ciudad    = document.getElementById('inp_ciudad');
            const inp_provincia = document.getElementById('inp_provincia');
            const inp_cp        = document.getElementById('inp_cp');

            // Cliente
            res_nombre.textContent   = f.nombre.value;
            res_telefono.textContent = f.telefono.value;
            res_dni.textContent      = f.dni.value;

            inp_nombre.value   = f.nombre.value;
            inp_telefono.value = f.telefono.value;
            inp_dni.value      = f.dni.value;
            inp_metodo.value   = f.metodo.value;

            // Entrega
            if (f.metodo.value === 'envio') {

                res_entrega.innerHTML =
                    `<strong>Envío a domicilio</strong><br>
                    ${f.calle.value} ${f.numero.value}, 
                    ${f.ciudad.value}, ${f.provincia.value} (${f.cp.value})`;

                inp_calle.value     = f.calle.value;
                inp_numero.value    = f.numero.value;
                inp_piso.value      = f.piso.value;
                inp_ciudad.value    = f.ciudad.value;
                inp_provincia.value = f.provincia.value;
                inp_cp.value        = f.cp.value;

            } else {
                res_entrega.textContent = 'Retiro en sucursal';
            }

            // Cerrar modal 1
            bootstrap.Modal.getInstance(
                document.getElementById('modalConfirmarCompra')
            ).hide();

            // Abrir modal 2
            new bootstrap.Modal(
                document.getElementById('modalResumenCompra')
            ).show();
        }
    </script>

</div>