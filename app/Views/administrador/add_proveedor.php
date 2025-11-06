    
    <!-- Enlace para crear categoria y productos -->
    <div class="text p-2">
        <h4 class="text-end me-5">
            <a href="<?php echo base_url('add_categoria');?>" class="botones btn btn-light custom-link m-auto d-inline-block me-1 p-2">Registrar Categoria </a>
            <a href="<?php echo base_url('add_producto');?>" class="botones btn btn-dark text-white custom-link m-auto d-inline-block p-2">Registrar Producto</a>
            <a href="<?php echo base_url('lista_proveedor');?>" class="botones botones btn d-inline-block formulario me-3 p-2">Tabla Proveedor </a>
        </h4>
    </div>
    
    <h1 class="display-3 text-center text-white m-2 pt-2 pb-2">Agregar Proveedor</h1>

</main>

<div class="container-proveedor pt-3">
    <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
        
        <!--  Condición para visualizar los mensajes de validación  -->
        <?php if (session('mensaje')): ?>
            <div class="alert alert-success" role="alert">
                <?= session('mensaje') ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de Registro -->
        <?php echo form_open("insertar_proveedor"); ?>

            <div class="card formulario p-3">
                <div class="card-body p-auto">
                            
                    <!-- Campos del formulario -->
                    <div class="mb-3">
                        <label for="nombre_proveedor" class="form-label">Nombre del Proveedor</label>
                        <?php echo form_input(['name' => 'nombre_proveedor', 'id' => 'nombre_proveedor', 'type' => 'text','class' => 'form-control form-input', 'value' => set_value('nombre_proveedor'), 'placeholder' => 'Ej. FictiCorp']); ?>

                        <!--  Condicion para visualizar los errores de validacion  -->
                        <?php if (isset($validation) && $validation->hasError('nombre_proveedor')): ?>
                            <div class="alert alert-danger m-auto">
                                
                                <!-- Muestra mensaje de error -->
                                <?= $validation->getError('nombre_proveedor'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="correo_proveedor" class="form-label">Correo</label>
                        <?php echo form_input(['name' => 'correo_proveedor', 'id' => 'correo_proveedor', 'type' => 'email', 'class' => 'form-control form-input', 'value' => set_value('correo_proveedor'), 'placeholder' => 'name@example.com']); ?>

                        <!--  Condicion para visualizar los errores de validacion  -->
                        <?php if (isset($validation) && $validation->hasError('correo_proveedor')): ?>
                            <div class="alert alert-danger m-auto">
                                
                                <!-- Muestra mensaje de error -->
                                <?= $validation->getError('correo_proveedor'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="telefono_proveedor" class="form-label">Telefono</label>
                        <?php echo form_input(['name' => 'telefono_proveedor', 'id' => 'telefono_proveedor', 'type' => 'text', 'class' => 'form-control form-input', 'value' => set_value('telefono_proveedor'), 'placeholder' => '54 0800 800']); ?>

                        <!--  Condicion para visualizar los errores de validacion  -->
                        <?php if (isset($validation) && $validation->hasError('telefono_proveedor')): ?>
                            <div class="alert alert-danger m-auto">
                                
                                <!-- Muestra mensaje de error -->
                                <?= $validation->getError('telefono_proveedor'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Botón de enviar -->
                <div class="col d-flex justify-content-center pb-2">
                    <?php echo form_submit('Agregar', 'Agregar', 'class="boton p-2"'); ?>
                </div>
            </div>
<br><br>
        <!-- Cierre del formulario -->
        <?php echo form_close(); ?>
    </div>
</div>
