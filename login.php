<section id="login" class="login" style="padding-top: 120px;">
  <div class="container small-container" id="container">
    <?php $validation = \Config\Services::validation(); ?>
    <div class="form-container sign-in">
      <form method="post" action="<?php echo base_url('/enviarlogin') ?>">
        <h1 style="margin-top: 15px;">Iniciar sesion</h1>
        <div class="form-group">
          <label for="email">Correo</label>
          <input name="email" type="text" class="form-control" placeholder="correo@gmail.com">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" placeholder="ingresa tu contraseña">
        </div>
        <div class="button-group">
          <button type="submit" class="btn btn-warning">Ingresar</button>
          <button type="button" class="btn btn-danger" onclick="window.location.href='<?php echo base_url('login'); ?>'">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</section>