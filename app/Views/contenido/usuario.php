    <h1 class="display-3 text-center text-white m-2 pt-2 pb-2">
        <span class="border-bottom"><strong><?php echo session('nombre_usuario'); ?> <?php echo session('apellido_usuario'); ?></strong></span>
    </h1>
</main>

<div class="container-user pt-3">
    <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">

        <!-- Condicion para visualizar los errores de validacion -->
        <?php if (session('mensaje')): ?>
            <div class="alert alert-light" role="alert">
                <?= session('mensaje') ?>
            </div>
        <?php endif; ?>

        <?= form_open_multipart("actualizar_usuario"); ?>

        <div class="card formulario p-3">
            <div class="card-body p-auto">

                <!-- Campos del formulario -->
                <div class="mb-3">
                    <label for="nombre_usuario">Nombre</label>
                    <?= form_input(['name' => 'nombre_usuario', 'id' => 'nombre_usuario', 'class' => 'form-control', 'value' => $usuario['nombre_usuario'], 'pattern' => '^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$', 'title' => 'Solo se permiten letras y espacios']); ?>
                </div>

                <div class="mb-3">
                    <label for="apellido_usuario">Apellido</label>
                    <?= form_input(['name' => 'apellido_usuario', 'id' => 'apellido_usuario', 'class' => 'form-control',  'value' => $usuario['apellido_usuario'], 'pattern' => '^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$', 'title' => 'Solo se permiten letras y espacios']); ?>
                </div>

                <div class="mb-3">
                    <label for="edad_usuario">Edad</label>
                    <?= form_input(['name' => 'edad_usuario', 'id' => 'edad_usuario', 'type' => 'number', 'min' => '18', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => $usuario['edad_usuario']]); ?>
                </div>

                <div class="mb-3">
                    <label for="correo_usuario">Correo</label>
                    <?= form_input(['name' => 'correo_usuario', 'id' => 'correo_usuario', 'type' => 'email', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => $usuario['correo_usuario']]); ?>
                </div>

                <!-- Contraseña Actual -->
                <div class="form-group my-3">
                    <label for="current_password">Contraseña Actual</label>
                    <input type="password" name="current_password" id="current_password" class="form-control <?= session('errors.current_password') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.current_password') ?>
                    </div>
                </div>

                <!-- Nueva Contraseña -->
                <div class="form-group my-3">
                    <label for="new_password">Nueva Contraseña</label>
                    <input type="password" name="new_password" id="new_password" class="form-control <?= session('errors.new_password') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.new_password') ?>
                    </div>
                </div>

                <!-- Confirmar Nueva Contraseña -->
                <div class="form-group my-3">
                    <label for="confirm_password">Confirmar Nueva Contraseña</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control <?= session('errors.confirm_password') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.confirm_password') ?>
                    </div>
                </div>
                
                <?= form_hidden('id_usuario', $usuario['id_usuario']); ?>
                <?= form_hidden('pass_usuario', $usuario['pass_usuario'] ?? ''); ?> <!-- Campo oculto para mantener la contraseña -->
            </div>

            <!-- Botón de enviar -->
            <div class="col d-flex justify-content-center pb-2">
                <?= form_submit('Modificar', 'Modificar', 'class="boton p-2"'); ?>
            </div>

        </div>

        <!-- Cierre del formulario -->
        <?= form_close(); ?>
<br>
    <!-- Boton para desactivar cuenta -->
        <?php if (session()->get('perfil_usuario') == 1) { ?>
            <a class="btn btn-danger botones text-white m-2"href="<?php echo base_url('estado/'.session()->get('id_usuario').'/0'); ?>">Desactivar Cuenta</a>
        <?php }?>
    
    </div>

    <br>
    
</div>
