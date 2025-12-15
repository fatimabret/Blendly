<div class="modal fade" id="modalResumenCompra" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content text-dark comprobante">

            <div class="modal-header">
                <h5 class="modal-title text-dark">Resumen de la Compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="<?= base_url('guardar_compra') ?>" method="post">

                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

                <!-- DATOS DE LA TIENDA -->
                    <div class="alert alert-light border">
                        <strong>Blendly Bebidas</strong><br>
                        Email: blendly.drinks@example.com<br>
                        Dirección: 9 de Julio 1449, Corrientes Capital, Argentina
                    </div>

                    <hr>

                <!-- DATOS DEL CLIENTE -->
                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col">
                            <h6>Datos del Cliente</h6>
                            <p class="text-dark">
                                <strong>Nombre:</strong> <span id="res_nombre"></span><br>
                                <strong>Teléfono:</strong> <span id="res_telefono"></span><br>
                                <strong>DNI / CUIL:</strong> <span id="res_dni"></span>
                            </p>
                        </div>
                        <div class="col">
                        <!-- ENTREGA -->
                            <h6>Forma de Entrega</h6>
                            <p id="res_entrega"></p>
                        </div>
                    </div>

                    <hr>

                <!-- PRODUCTOS -->
                    <h6>Detalle de Productos</h6>

                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cant.</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cart = \Config\Services::cart();
                            $total = 0;
                            foreach ($cart->contents() as $item):
                                $sub = $item['qty'] * $item['price'];
                                $total += $sub;
                            ?>
                        <tr>
                            <td><?= esc($item['name']) ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td>$<?= $item['price'] ?></td>
                            <td>$<?= $sub ?></td>
                        </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <h5 class="text-end">Total: $<?= $total ?></h5>

                    <hr>

                <!-- MÉTODO DE PAGO -->
                    <h6>Método de Pago</h6>
                    <select name="metodo_pago" class="form-select" required>
                        <option value="">Seleccionar…</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="mercadopago">Mercado Pago</option>
                    </select>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="generar_pdf" value="1" id="generar_pdf" checked>
                        <label class="form-check-label" for="generar_pdf">
                            Generar comprobante en PDF
                        </label>
                    </div>

                <!-- CAMPOS OCULTOS -->
                    <input type="hidden" name="nombre" id="inp_nombre">
                    <input type="hidden" name="telefono" id="inp_telefono">
                    <input type="hidden" name="dni" id="inp_dni">
                    <input type="hidden" name="metodo" id="inp_metodo">

                    <input type="hidden" name="calle" id="inp_calle">
                    <input type="hidden" name="numero" id="inp_numero">
                    <input type="hidden" name="piso" id="inp_piso">
                    <input type="hidden" name="ciudad" id="inp_ciudad">
                    <input type="hidden" name="provincia" id="inp_provincia">
                    <input type="hidden" name="cp" id="inp_cp">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver</button>
                    <button type="submit" class="btn btn-success">
                        Confirmar Pago y Comprar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
