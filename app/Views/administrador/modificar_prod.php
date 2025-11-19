<h1 class="display-3 text-center text-white m-2 pt-2 pb-2">Edición de Producto</h1>

</main>

<div class="container-modificar pt-3">
    <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">

        <!-- Condición para visualizar los errores de validación -->
        <?php if (session('mensaje')): ?>
            <div class="alert alert-danger" role="alert">
                <?= session('mensaje') ?>
            </div>
        <?php endif; ?>

        <?php echo form_open_multipart("actualizar"); ?>

        <div class="card formulario p-3">
            <div class="card-body p-auto">

                <!-- Campos del formulario -->
                <div class="mb-3">
                    <label for="nombre_producto">Nombre del Producto</label>
                    <?php echo form_input(['name' => 'nombre_producto', 'id' => 'nombre_producto', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => $producto['nombre_producto'] ]); ?>
                    <!-- Verifica si hay errores de validación para el campo -->
                    <?php if (isset($validation) && $validation->hasError('nombre_producto')): ?>
                        <div class="alert alert-danger mt-2">
                            <!-- Muestra mensaje de error -->
                            <?= $validation->getError('nombre_producto'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="proveedor_producto">Proveedor</label>
                    <?php 
                        $lista_proveedores;
                        foreach ($producto_proveedor as $row) {
                            $lista_proveedores[$row['id_proveedor']] = $row['nombre_proveedor'];
                        }
                        $selected_proveedor = $producto['proveedor_producto'];
                        echo form_dropdown('proveedor_producto', $lista_proveedores, $selected_proveedor, 'class="form-control form-select"'); 
                    ?>
                </div>

                <div class="mb-3">
                    <label for="descripcion_producto">Descripción</label>
                    <?php echo form_textarea(['name' => 'descripcion_producto', 'id' => 'descripcion_producto', 'rows' => '2', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => $producto['descripcion_producto'] ]); ?>
                    <?php if (isset($validation) && $validation->hasError('descripcion_producto')): ?>
                        <div class="alert alert-danger mt-2">
                            <?= $validation->getError('descripcion_producto'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="precio_producto">Precio</label>
                    <?php echo form_input(['name' => 'precio_producto', 'id' => 'precio_producto', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => $producto['precio_producto'], 'pattern' => '^[0-9]+(\.[0-9]{1,2})?$',  'title' => 'Solo números. Puede incluir decimales como 1500.50']); ?>

                    <?php if (isset($validation) && $validation->hasError('precio_producto')): ?>
                        <div class="alert alert-danger mt-2">
                            <?= $validation->getError('precio_producto'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="imagen_producto">Imagen</label>
                    <br>
                    <?php if (!empty($producto['imagen_producto'])): ?>
                        <img src="<?php echo base_url('assets/img/producto/' . $producto['imagen_producto']); ?>" alt="Imagen del Producto" class="custom-image" />
                    <?php endif; ?>
                    <?php echo form_input(['name' => 'imagen_producto', 'id' => 'imagen_producto', 'type' => 'file']); ?>
                    <?php if (isset($validation) && $validation->hasError('imagen_producto')): ?>
                        <div class="alert alert-danger mt-2">
                            <?= $validation->getError('imagen_producto'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="stock_producto">Stock del producto</label>
                    <?php echo form_input(['name' => 'stock_producto', 'id' => 'stock_producto', 'type' => 'number', 'min' => '0', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => $producto['stock_producto'] ]); ?>
                    <?php if (isset($validation) && $validation->hasError('stock_producto')): ?>
                        <div class="alert alert-danger mt-2">
                            <?= $validation->getError('stock_producto'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="categoria_producto">Categoría</label>
                    <?php 
                        $lista_categoria;
                        foreach ($producto_categoria as $row) {
                            $lista_categoria[$row['id_categoria']] = $row['nombre_categoria'];
                        }
                        $categoria = $producto['categoria_producto'];
                        echo form_dropdown('categoria_producto', $lista_categoria, $categoria, 'class="form-control form-select"'); 
                    ?>
                </div>

                <?php echo form_hidden('id', $producto['id_producto']); ?>
            </div>

            <!-- Botón de enviar -->
            <div class="col d-flex justify-content-center pb-2">
                <?php echo form_submit('Modificar', 'Modificar', 'class="boton p-2"'); ?>
            </div>

        </div>

        <!-- Cierre del formulario -->
        <?php echo form_close(); ?>

    </div>

    <br><br>

</div>
