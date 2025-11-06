    
    <div class="text p-2">
        <h4 class="text-end me-5">
            <a href="<?php echo base_url('add_proveedor');?>" class="botones btn btn-light custom-link m-auto d-inline-block me-1 p-2">Registrar Proveedor</a>
            <a href="<?php echo base_url('add_producto');?>" class="botones btn btn-dark text-white custom-link m-auto d-inline-block p-2">Registrar Producto</a>
        </h4>
    </div>
    
    <h1 class="display-3 text-center text-white m-2 pt-2 pb-2">Agregar Categoría</h1>

</main>

<div class="container-categoria pt-3">
    <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
        
        <!--  Condición para visualizar los mensajes de validación  -->
        <?php if (session('mensaje')): ?>
            <div class="alert alert-success" role="alert">
                <?= session('mensaje') ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de Registro -->
        <?php echo form_open("insertar_categoria"); ?>

            <div class="card formulario p-3">
                <div class="card-body p-auto">
                            
                    <!-- Campos del formulario -->
                    <div class="mb-3">
                        <label for="nombre_categoria" class="form-label">Nombre de la Categoría</label>
                        <?php echo form_input(['name' => 'nombre_categoria', 'id' => 'nombre_categoria', 'class' => 'form-control form-input', 'value' => set_value('nombre_categoria'), 'placeholder' => 'Ej. Exclus']); ?>

                        <!--  Condicion para visualizar los errores de validacion  -->
                        <?php if (isset($validation) && $validation->hasError('nombre_categoria')): ?>
                            <div class="alert alert-danger m-auto">
                                
                                <!-- Muestra mensaje de error -->
                                <?= $validation->getError('nombre_categoria'); ?>
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
