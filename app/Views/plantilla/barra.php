
  <!-- Barra de navegación -->
  <div class="container-navbar">
    <nav class="navbar navbar-expand-lg me-auto mb-2 mb-lg-0 pt-0 pb-0">
      <div class="container-fluid">

      <!-- Mascota de la marca -->
        <a class="navbar-brand" href="<?php echo base_url('principal');?>">
          <img src="<?php echo base_url('assets/img/mapache01.png');?>" alt="Inicio" width="25" height="20">
        </a>

      <!-- Botón desplegable para dispositivos móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

      <!-- Menú de navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <!-- Elementos del administrador -->
            <?php if (session()->get('perfil_usuario') == 2) { ?>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('lista_consulta');?>"><strong>Ver Consultas</strong></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('ventas');?>"><strong>Listar Ventas</strong></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('lista_producto');?>"><strong>Listar Productos</strong></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('add_producto');?>"><strong>Registrar Producto</strong></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('gestionar_prod');?>"><strong>Gestionar Productos</strong></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('gestionar_user');?>"><strong>Gestionar Usuarios</strong></a>
              </li>

            <?php } else {?>

            <!-- Elementos del menú -->
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('principal');?>"><strong>Home</strong></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('contacto');?>"><strong>Contacto</strong></a>
              </li>

              <?php if (session()->get('perfil_usuario') == 1) { ?>
                
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('mis_consultas');?>"><strong>Mis Consultas</strong></a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('mi_compra');?>"><strong>Mis Compras</strong></a>
                </li>

              <?php }?>
              
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('comercializacion');?>"><strong>Comercializacion</strong></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('productos');?>"><strong>Productos</strong></a>
              </li>

            <?php }?>
          </ul>
          
          <form class="container-fluid justify-content-start" role="search">
            <div class="d-flex justify-content-center m-auto me-2">

              <?php if (session()->get('logged')) { ?>

                <!-- Botones de carrito y cerrar sesión -->
                <?php if (session()->get('perfil_usuario') == 1) { ?>
                  <a href="<?=base_url('carrito')?>" class="m-auto me-2"><img src="<?php echo base_url('assets/img/icons/carrit.png');?>" alt="Carrito" width="30" height="30"></a>
                <?php }?>

                <a href="<?=base_url('mi_perfil')?>" class="m-auto nav-link me-2"><strong><?php echo session('nombre_usuario');?> </strong><img src="<?php echo base_url('assets/img/icons/user.png');?>" alt="User" width="30" height="30"></a>
                
                <a href="<?=base_url('cerrar_sesion')?>" class="m-auto nav-link"><strong>Close</strong><img src="<?php echo base_url('assets/img/icons/cls.png');?>" alt="Cerrar Sesion" width="30" height="30"></a>
              
              <?php } else {?>

                <!-- Botones de registro e inicio de sesión -->
                <a href="<?=base_url('registrar_cliente')?>" class="botones btn bt custom-link text-white m-1 p-2" style="background: #1b243a;"><strong>Registrarse</strong></a>
                
                <a href="<?=base_url('iniciarSesion')?>" class="botones btn bt btn-light custom-link m-1 p-1"><strong>Iniciar Sesión</strong></a>

              <?php }?>
            </div>
          </form>
        </div>
      </div>
    </nav>
  </div>

<main>