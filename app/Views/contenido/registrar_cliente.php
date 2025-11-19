<!-- Texto introductorio -->
        <h1 class="display-3 text-center p-auto"><a href="<?php echo base_url('principal');?>" class="text-titulo d-inline-block text-white m-2">BLENDLY</a></h1>
        <hr>
        <p class="display-6 text-center pt-2 pb-2">Regístrate para disfrutar de nuestros productos exclusivos.<br></p>
    
    </main>

<!-- Contenedor principal -->
    <div class="container-registrar">
        <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">

            <!--  Condicion para visualizar los errores de validacion  -->
            <?php if (session('mensaje')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session('mensaje') ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de Registro -->
            <?php echo form_open('registrar_cliente') ?>

            <div class="card formulario p-3">
                <div class="card-body p-auto">
                            
                <!-- Campos del formulario -->
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label">Nombre</label>
                        <?php echo form_input(['name' => 'nombre_usuario', 'id' => 'nombre_usuario', 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Ej. Juan', 'value' => set_value('nombre_usuario'), 'pattern' => '^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$', 'title' => 'Solo se permiten letras y espacios']); ?>

                        <!-- Verifica si hay errores de validación para el campo -->
                        <?php if (isset($validation) && $validation->hasError('nombre_usuario')): ?>
                            <div class="alert alert-danger m-auto">
                                
                                <!-- Muestra mensaje de error -->
                                <?= $validation->getError('nombre_usuario'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="apellido_usuario" class="form-label">Apellido</label>
                        <?php echo form_input(['name' => 'apellido_usuario', 'id' => 'apellido_usuario', 'type' => 'text','class' => 'form-control', 'placeholder' => 'Ej. Perez', 'value' => set_value('apellido_usuario'), 'pattern' => '^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$', 'title' => 'Solo se permiten letras y espacios']); ?>
                        
                        <!-- Verifica si hay errores de validación para el campo -->
                        <?php if (isset($validation) && $validation->hasError('apellido_usuario')): ?>
                            <div class="alert alert-danger m-auto">
                                
                                <!-- Muestra mensaje de error -->
                                <?= $validation->getError('apellido_usuario'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="edad_usuario" class="form-label">Edad</label>
                        <?php echo form_input(['name' => 'edad_usuario', 'id' => 'edad_usuario', 'type' => 'number', 'min' => '18', 'class' => 'form-control','placeholder' => 'Ej. 21', 'value' => set_value('edad_usuario')]); ?>
                                    
                        <!-- Verifica si hay errores de validación para el campo -->
                        <?php if (isset($validation) && $validation->hasError('edad_usuario')): ?>
                            <div class="alert alert-danger m-auto">
                                
                                <!-- Muestra mensaje de error -->
                                <?= $validation->getError('edad_usuario'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="correo_usuario" class="form-label">Correo electrónico</label>
                        <?php echo form_input(['name' => 'correo_usuario', 'id' => 'correo_usuario', 'type' => 'email', 'class' => 'form-control', 'placeholder' => 'name@example.com', 'value' => set_value('correo_usuario')]); ?>
                                
                        <!-- Verifica si hay errores de validación para el campo -->
                        <?php if (isset($validation) && $validation->hasError('correo_usuario')): ?>
                            <div class="alert alert-danger m-auto">
                                
                                <!-- Muestra cada mensaje de error -->
                                <?= $validation->getError('correo_usuario'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                        
                    <div class="mb-3">
                        <label for="pass_usuario" class="form-label">Contraseña</label>
                        <?php echo form_password(['name' => 'pass_usuario', 'id' => 'pass_usuario', 'class' => 'form-control', 'placeholder' => '************']); ?>

                        <!-- Verifica si hay errores de validación para el campo -->
                        <?php if (isset($validation) && $validation->hasError('pass_usuario')): ?>
                            <div class="alert alert-danger m-auto">
                                
                                <!-- Muestra cada mensaje de error -->
                                <?= $validation->getError('pass_usuario'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="repass_usuario" class="form-label">Repetir contraseña</label>
                        <?php echo form_password(['name' => 'repass_usuario', 'id' => 'repass_usuario', 'class' => 'form-control', 'placeholder' => '************']); ?>

                        <!-- Verifica si hay errores de validación para el campo -->
                        <?php if (isset($validation) && $validation->getError('repass_usuario')): ?>
                            <div class="alert alert-danger m-auto">

                                <!-- Muestra cada mensaje de error -->
                                <?= $validation->getError('repass_usuario'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <!-- Condicion de aceptacion a los terminos -->
                <div class="col-auto ms-3 m-auto">
                    <p>Prohibido la venta a menores de edad. <br>
                    Al registrarte, aceptas nuestros <a href="<?php echo base_url('terminosUsos');?>" class="d-inline-block">Términos y Usos</a>.</p>
                </div>

            <!-- Botón de enviar formulario -->
                <div class="col d-flex justify-content-center pb-2">
                    <?php echo form_submit('registro_cliente', 'Registrarme', 'class="boton botones bt p-2"');?>
                </div>
                    
            </div>

        <!-- Cierre del formulario -->
            <?php echo form_close(); ?>
        </div>

        <!-- Enlace para Iniciar Sesion -->
        <div class="text pt-4 pb-4">
            <h4 class="text-center">¿Tienes una cuenta? <a href="<?php echo base_url('iniciarSesion');?>" class="d-inline-block text-white m-2">Inicia sesión</a></h4>
        </div>
    </div>

