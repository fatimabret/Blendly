
<!-- Carrusel de imágenes -->
   <div id="carouselExampleFade" class="carousel slide carousel-fade">
      <div class="carousel-inner">

      <!-- Imágenes del carrusel -->
         <div class="carousel-item active">
            <img src="<?=base_url('assets/img/carrusel_2.png')?>" class="d-block w-100" alt="...">
         </div>
         <div class="carousel-item">
            <img src="<?=base_url('assets/img/carrusel_3.png')?>" class="d-block w-100" alt="...">
         </div>
      </div>

   <!-- Botones de navegación del carrusel -->
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
         <span class="carousel-control-next-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Next</span>
      </button>
   </div>

</main>

<!-- Título de bienvenida -->
   <h1 class="display-4 text-center pt-5">¡Bienvenido a Blendly!</h1>

<!-- Contenedor del texto con borde -->
   <div class="clearfix">
      <div class="col-md-6 bordered-text">
         <p class="lead">Somos mucho más que una tienda de bebidas, no solo nos preocupamos por ofrecerte bebidas excepcionales, sino que también nos esforzamos por proporcionarte una experiencia de compra única. Descubre cómo cada botella cuenta una historia propia, llena de calidad, frescura y sabor incomparables.
            <br><a href="<?php echo base_url('contacto');?>"><button type="button" class="btn btn-lg custom-link text-white">Ver más... </button></a>
         </p>
         <p class="lead">¡Te invitamos a sumergirte en nuestro mundo y disfrutar de la excelencia en cada sorbo!</p>
         
      <!-- Botón de explorar catálogo -->
         <a href="<?=base_url('productos')?>" class="botones btn btn-light custom-link mt-3 d-inline-block">Explora nuestro catálogo</a>
      </div>
      
   <!-- Imagen de la mascota -->
      <img src="<?php echo base_url('assets/img/mapache00.png');?>" class="col-md-6 float-md-end mb-1 ms-md-3 bordered-image" alt="...">
   </div>

<!-- Texto secundario -->
   <small class="text-segundos display-6 text-center">¿Qué vas a tomar hoy? <br></small>

<!-- Título de productos destacados -->
   <div class="text pt-5">
               <h3 class="display-4 text-center mb-4">Productos Destacados</h3>
   </div>

<!-- Contenedor de productos destacados -->
   <div class="conteiner-car">
      <div class="row-principal row row-cols-1 row-cols-md-2 mt-auto mb-5">

      <!-- Tarjetas de producto destacado -->
         <?php if (!empty($vendidosProductos)) : ?>
            <?php foreach ($vendidosProductos as $producto) : ?>
               <div class="col">

                  <a href="<?= base_url('categorias/mas_vendidos') ?>" class="text-titulo text-dark">
                     <div class="prod card border border-5 mt-5">
                        <img src="<?= base_url('assets/img/producto/' . $producto['imagen_producto']) ?>" class="card-img-top" alt="<?= $producto['nombre_producto'] ?>">

                        <div class="card-body">

                           <h5 class="card-title"><?= $producto['nombre_producto'] ?></h5>
                           <h6>(<?= $producto['nombre_categoria']; ?>)</h6>
                           
                           <p class="card-text"><?= $producto['descripcion_producto'] ?></p>
                           <h5>$<?= $producto['precio_producto'] ?></h5>

                           <?php if ($producto['id_estado'] == 1 && $producto['stock_producto'] > 0): ?>
                              <p class="card-footer"><strong>Stock:</strong> <?= $producto['stock_producto'] ?></p>
                           <?php endif; ?>

                           <?php if (session()->get('perfil_usuario') == 1 && $producto['id_estado'] == 1): ?>
                              <?= form_open('add_carrito', 'class="text-center p-auto"') ?>
                                 <?= form_hidden('id_producto', $producto['id_producto']) ?>
                                 <?= form_hidden('nombre_producto', $producto['nombre_producto']) ?>
                                 <?= form_hidden('precio_producto', $producto['precio_producto']) ?>
                                 <?= form_hidden('stock_producto', $producto['stock_producto']) ?>
                                 <?= form_submit('comprar', 'Agregar carrito', 'class="boton btn btn-success p-0 pb-2 pt-2"') ?>
                              <?= form_close() ?>
                           <?php elseif (session()->get('perfil_usuario') == 1 && $producto['id_estado'] == 0): ?>
                              <!-- Botón para dar de alta -->
                              <button type="button" class="btn btn-secondary btn-lg" disabled>Sin Stock</button>
                           <?php endif; ?>

                           <?php if (session()->get('perfil_usuario') == 2 && $producto['id_estado'] == 1): ?>
                              <!-- Botón para dar de baja -->
                              <a href="<?= base_url('estado_producto/' . $producto['id_producto'].'/0') ?>" class="btn btn-danger">Dar de baja</a>
                           <?php elseif (session()->get('perfil_usuario') == 2 && $producto['id_estado'] == 0): ?>
                              <?php if ($producto['stock_producto'] > 0): ?>
                                 <!-- Si tiene stock, puede activar -->
                                 <a href="<?= base_url('estado_producto/' . $producto['id_producto'].'/1') ?>" class="btn btn-success">Dar de alta</a>
                              <?php else: ?>
                                 <!-- Si NO tiene stock, dirigir a editar -->
                                 <a href="<?= base_url('editar/' . $producto['id_producto']) ?>" class="btn btn-warning">Agregar Stock</a>
                              <?php endif; ?>   
                           <?php endif; ?>
                           
                        </div>
                     </div>
                  </a>
               </div>
            <?php endforeach; ?>
         <?php endif; ?>
      </div>
   </div>

<!-- Título de últimos ingresos -->
   <div class="text pt-3">
               <h3 class="display-5 text-center mb-4">Ultimos Ingresos!</h3>
   </div>

<!-- Contenedor de últimos ingresos -->
   <div class="conteiner-car">
      <div class="row-principal row row-cols-1 row-cols-md-3 mt-auto mb-5">

      <!-- Tarjetas de último ingreso -->
         <?php if (!empty($ultimosProductos)) : ?>
            <?php foreach ($ultimosProductos as $producto) : ?>
               <div class="col">

               <a href="<?= base_url('categorias/orden/fecha/desc') ?>" class="text-titulo text-dark">
                     <div class="prod card border border-5 mt-5">
                        <img src="<?= base_url('assets/img/producto/' . $producto['imagen_producto']) ?>" class="card-img-top" alt="<?= $producto['nombre_producto'] ?>">

                        <div class="card-body">

                           <h5 class="card-title"><?= $producto['nombre_producto'] ?></h5>
                           <a href="<?= base_url('categorias/categoria/' . $producto['id_categoria']) ?>" class="text-titulo text-black">
                              <h6>(<?= $producto['nombre_categoria']; ?>)</h6>
                           </a>
                           
                           <p class="card-text"><?= $producto['descripcion_producto'] ?></p>
                           <h5>$<?= $producto['precio_producto'] ?></h5>

                           <?php if ($producto['id_estado'] == 1 && $producto['stock_producto'] > 0): ?>
                              <p class="card-footer"><strong>Stock:</strong> <?= $producto['stock_producto'] ?></p>
                           <?php endif; ?>
                                       
                           <?php if (session()->get('perfil_usuario') == 1 && $producto['id_estado'] == 1): ?>
                              <?= form_open('add_carrito', 'class="text-center p-auto"') ?>
                                 <?= form_hidden('id_producto', $producto['id_producto']) ?>
                                 <?= form_hidden('nombre_producto', $producto['nombre_producto']) ?>
                                 <?= form_hidden('precio_producto', $producto['precio_producto']) ?>
                                 <?= form_hidden('stock_producto', $producto['stock_producto']) ?>
                                 <?= form_submit('comprar', 'Agregar carrito', 'class="boton btn btn-success p-0 pb-2 pt-2"') ?>
                              <?= form_close() ?>
                           <?php elseif (session()->get('perfil_usuario') == 1 && $producto['id_estado'] == 0): ?>
                              <!-- Botón para dar de alta -->
                              <button type="button" class="btn btn-secondary btn-lg" disabled>Sin Stock</button>
                           <?php endif; ?>

                           <?php if (session()->get('perfil_usuario') == 2 && $producto['id_estado'] == 1): ?>
                              <!-- Botón para dar de baja -->
                              <a href="<?= base_url('estado_producto/' . $producto['id_producto'].'/0') ?>" class="btn btn-danger">Dar de baja</a>
                           <?php elseif (session()->get('perfil_usuario') == 2 && $producto['id_estado'] == 0): ?>
                              <?php if ($producto['stock_producto'] > 0): ?>
                                 <!-- Si tiene stock, puede activar -->
                                 <a href="<?= base_url('estado_producto/' . $producto['id_producto'].'/1') ?>" class="btn btn-success">Dar de alta</a>
                              <?php else: ?>
                                 <!-- Si NO tiene stock, dirigir a editar -->
                                 <a href="<?= base_url('editar/' . $producto['id_producto']) ?>" class="btn btn-warning">Agregar Stock</a>
                              <?php endif; ?>
                           <?php endif; ?>
                           
                        </div>
                     </div>
                  </a>   
               </div>
            <?php endforeach; ?>
         <?php endif; ?>
      </div>
   </div>

   <div class="modal fade" id="modalCompraExitosa" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">

               <div class="modal-header bg-success text-white">
                  <h5 class="modal-title text_ dark">Compra confirmada</h5>
               </div>

               <div class="modal-body text-center">
                  <p class="text-dark">
                     ¡Gracias por tu compra!<br>
                     Tu pedido fue registrado correctamente.
                  </p>

                  <?php if (session()->getFlashdata('generar_pdf')): ?>
                     <a
                        href="<?= base_url('pedido/pdf/' . session()->getFlashdata('id_pedido')) ?>"
                        target="_blank"
                        class="btn btn-outline-success mt-2"
                     >
                        Descargar comprobante (PDF)
                     </a>
                  <?php endif; ?>
               </div>
            <a href="<?= base_url('mi_compra') ?>" class="btn btn-outline-success">
               Ver mis compras
            </a>
         </div>
      </div>
   </div>

   <?php if (session()->getFlashdata('compra_exitosa')): ?>
      <script>
         document.addEventListener('DOMContentLoaded', function () {

            <?php if (session()->getFlashdata('generar_pdf')): ?>
                  window.open(
                     "<?= base_url('pedido/pdf/' . session()->getFlashdata('id_pedido')) ?>",
                     "_blank"
                  );
            <?php endif; ?>

            const modal = new bootstrap.Modal(
                  document.getElementById('modalCompraExitosa')
            );
            modal.show();
         });
      </script>
   <?php endif; ?>

