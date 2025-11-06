        <div class="text p-2">

            <h4 class="text-end me-5">
                <a href="<?php echo base_url('add_categoria');?>" class="botones btn btn-light custom-link m-auto d-inline-block me-1 p-2">Registrar Categoria </a>
                <a href="<?php echo base_url('add_proveedor');?>" class="botones btn btn-dark text-white custom-link m-auto d-inline-block p-2">Registrar Proveedor</a>
            </h4>
        </div>

        <h1 class="display-3 text-center text-white m-2 pt-2 pb-2">Agregar Producto</h1>

    </main>

    <div class="container-inciar pt-3">
        <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
                
            <!--  Condicion para visualizar los errores de validacion  -->
            <?php if (session('mensaje')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session('mensaje') ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de Producto -->
            <?php echo form_open_multipart("agregar_producto"); ?>

                <div class="card formulario p-3">
                    <div class="card-body p-auto">
                                
                        <!-- Campos del formulario -->
                        <div class="mb-3">
                            <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                            <?php echo form_input(['name' => 'nombre_producto', 'id' => 'nombre_producto', 'type' => 'text', 'class' => 'form-control form-input', 'value' => set_value('nombre_producto'), 'placeholder' => 'Ej. Coñac']); ?>

                            <!--  Condicion para visualizar los errores de validacion  -->
                            <?php if (isset($validation) && $validation->hasError('nombre_producto')): ?>
                                <div class="alert alert-danger m-auto">
                                    
                                    <!-- Muestra mensaje de error -->
                                    <?= $validation->getError('nombre_producto'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="proveedor_producto" class="form-label">Nombre del Proveedor</label>
                            
                            <?php $lista;
                                foreach ($producto_proveedor as $row) {
                                    $lista[$row['id_proveedor']] = $row['nombre_proveedor'];
                                }
                                
                                echo form_dropdown('proveedor_producto', $lista, set_value('proveedor_producto'), 'class="form-control form-select"');
                            ?>
                            
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_producto" class="form-label">Descripcción</label>
                            <?php echo form_textarea(['name' => 'descripcion_producto', 'id' => 'descripcion_producto', 'class' => 'form-control form-input', 'rows' => '2','value' => set_value('descripcion_producto'), 'placeholder' => 'Ej. Itaque, commodi incidunt nesciunt molestias nisi temporibus velit ab possimus. Eos, nemo quae!']); ?>

                            <!--  Condicion para visualizar los errores de validacion  -->
                            <?php if (isset($validation) && $validation->hasError('descripcion_producto')): ?>
                                <div class="alert alert-danger m-auto">
                                    
                                    <!-- Muestra mensaje de error -->
                                    <?= $validation->getError('descripcion_producto'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="precio_producto" class="form-label">Precio</label>
                            <?php echo form_input(['name' => 'precio_producto', 'id' => 'precio_producto', 'min' => '0', 'class' => 'form-control form-input', 'value' => set_value('precio_producto'), 'placeholder' => 'Ej. 999.99']); ?>

                            <!--  Condicion para visualizar los errores de validacion  -->
                            <?php if (isset($validation) && $validation->hasError('precio_producto')): ?>
                                <div class="alert alert-danger m-auto">
                                    
                                    <!-- Muestra mensaje de error -->
                                    <?= $validation->getError('precio_producto'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="imagen_producto" class="form-label">Imagen</label>
                            <br>
                            <?php echo form_input(['name' => 'imagen_producto', 'id' => 'imagen_producto', 'type' => 'file', 'class' => 'form-control']); ?>

                            <!--  Condicion para visualizar los errores de validacion  -->
                            <?php if (isset($validation) && $validation->hasError('imagen_producto')): ?>
                                <div class="alert alert-danger m-auto">
                                    
                                    <!-- Muestra mensaje de error -->
                                    <?= $validation->getError('imagen_producto'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="stock_producto" class="form-label">Stock</label>
                            <?php echo form_input(['name' => 'stock_producto', 'id' => 'stock_producto', 'type' => 'number', 'min' => '0', 'class' => 'form-control form-input', 'value' => set_value('stock_producto'), 'placeholder' => 'Ej. 99']); ?>

                            <!--  Condicion para visualizar los errores de validacion  -->
                            <?php if (isset($validation) && $validation->hasError('stock_producto')): ?>
                                <div class="alert alert-danger m-auto">
                                    
                                    <!-- Muestra mensaje de error -->
                                    <?= $validation->getError('stock_producto'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="categoria_producto" class="form-label">Categoría</label>
                            
                            <?php $lista;
                                foreach ($producto_categoria as $row) {
                                    $lista[$row['id_categoria']] = $row['nombre_categoria'];
                                }
                                
                                echo form_dropdown('categoria_producto', $lista, set_value('categoria_producto'), 'class="form-control form-select"');
                            ?>
                        </div>
                    </div>

                    <!-- Botón de enviar -->
                    <div class="col d-flex justify-content-center pb-2">
                        <?php echo form_submit('Agregar', 'Agregar', 'class="boton p-2"'); ?>
                    </div>

                </div>

            <!-- Cierre del formulario -->
            <?php echo form_close(); ?>
        </div>
<br><br>
    </div>