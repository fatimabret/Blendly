
    <div class="container-inciar align-content-center text-center">
        <p class="display-6">Te damos la bienvenida a Blendly</p>
    </div>

    <hr>
</main>

    
<!-- Contenedor principal -->
    <div class="container-inciar pt-3 pb-5">
        <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">

        <!--  Condicion para visualizar los errores de validacion  -->
            <?php if (session('mensaje')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= session('mensaje') ?>
                </div>
            <?php endif; ?>

        <!-- Formulario de Iniciar Sesion -->
            <?php echo form_open('iniciarSesion') ?>

            <div class="card formulario p-3">
                <div class="card-body p-auto">
                        
                <!-- Campos del formulario -->
                    <div class="mb-3">
                        <label for="correo_usuario" class="form-label">Correo electrónico</label>
                        <?php echo form_input(['name' => 'correo_usuario', 'id' => 'correo_usuario', 'type' => 'email', 'class' => 'form-control', 'placeholder' => 'name@example.com']); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="pass_usuario" class="form-label">Contraseña</label>
                        <?php echo form_password(['name' => 'pass_usuario', 'id' => 'pass_usuario', 'class' => 'form-control', 'placeholder' => '************']); ?>
                    </div>
                </div>

                <!-- Botón de enviar formulario -->
                <div class="col d-flex justify-content-center pb-2">
                    <?php echo form_submit('iniciarSesion', 'Iniciar Sesion', "class='boton p-2'");?>
                </div>
                
                <hr>

                <!-- Botón para ir a registrar cuenta -->
                <a href="<?=base_url('registrar_cliente')?>" class="botones btn btn-light custom-link m-auto d-inline-block p-2">Crear cuenta nueva</a>
            </div>

        <!-- Cierre del formulario -->
            <?php echo form_close(); ?>
        </div>
    </div>

