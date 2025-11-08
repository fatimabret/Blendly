<!-- Título de productos -->
<div class="text m-2">
    <h3 class="display-6 text-center text-segundos"><strong>¿Qué vas a tomar hoy?</strong></h3>
</div>
</main>

<!-- Contenedor principal -->
<div class="container-fluid">
    <div class="row">
        <!-- Barra lateral -->
        <div class="col-md-3">
            <div class="sidebar">
                <nav class="navba1r m-0">
                    <div class="container-fluid mt-3 mb-3">
                        <form class="d-flex" action="<?= base_url('producto/buscar') ?>" method="get">
                            <input class="form-control me-2" type="search" name="q" placeholder="¿Qué estás buscando?"
                                aria-label="Buscar">
                            <button class="botones btn bt" style="background: #1b243a;" type="submit">
                                <img src="<?= base_url('assets/img/icons/buscar.png') ?>" alt="Buscar" width="30"
                                    height="30">
                            </button>
                        </form>
                    </div>
                </nav>

                <h3>Categorías</h3>
                <ul class="list-group">
                    <!-- Filtrar productos por categoría -->
                    <?php foreach ($categorias as $categoria): ?>
                    <li class="list-group-item">
                        <a href="<?= base_url('categorias/categoria/' . $categoria['id_categoria']) ?>"
                            class="text-titulo color-nav">
                            <strong><?= $categoria['nombre_categoria'] ?></strong>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    <li class="list-group-item">
                        <a href="<?= base_url('categorias/mas_vendidos') ?>" class="text-titulo color-nav"><strong>Más
                                Vendidos</strong></a>
                    </li>
                    <li class="list-group-item">
                        <a href="<?= base_url('productos') ?>" class="text-titulo color-nav">
                            <strong>Todos los Productos</strong></a>
                    </li>
                </ul>

                <h3><br>Filtrar por </h3>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="<?= base_url('categorias/orden/asc') ?>" class="text-titulo color-nav"><strong>Precio:
                                Menor a Mayor</strong></a>
                    </li>
                    <li class="list-group-item">
                        <a href="<?= base_url('categorias/orden/desc') ?>" class="text-titulo color-nav"><strong>Precio:
                                Mayor a Menor</strong></a>
                    </li>
                    <li class="list-group-item">
                        <a href="<?= base_url('categorias/orden/alfabeto/asc') ?>"
                            class="text-titulo color-nav"><strong>A-Z</strong></a>
                    </li>
                    <li class="list-group-item">
                        <a href="<?= base_url('categorias/orden/alfabeto/desc') ?>"
                            class="text-titulo color-nav"><strong>Z-A</strong></a>
                    </li>
                    <li class="list-group-item">
                        <a href="<?= base_url('categorias/orden/fecha/desc') ?>"
                            class="text-titulo color-nav"><strong>Más nuevos</strong></a>
                    </li>
                    <li class="list-group-item">
                        <a href="<?= base_url('categorias/orden/fecha/asc') ?>"
                            class="text-titulo color-nav"><strong>Más antiguos</strong></a>
                    </li>
                </ul>

            </div>
        </div>

        <!-- Contenedor para los productos -->
        <div class="col-md-9">
            <div class="conteiner-car">
                <div class="row-producto row row-cols-1 row-cols-md-2 mt-auto mb-5">
                    <?php foreach ($productos as $producto): ?>
                    <div class="col">
                        <div class="prod card border-5 mt-3 mb-5">
                            <img src="<?= base_url('assets/img/producto/' . $producto['imagen_producto']) ?>"
                                class="card-img-top" alt="<?= $producto['nombre_producto'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $producto['nombre_producto'] ?></h5>
                                <h6>(<?= $producto['nombre_categoria']; ?>)<br></h6>
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
                                <!-- Botón sin stock -->
                                <button type="button" class="btn btn-secondary btn-lg" disabled>Sin Stock</button>
                                <?php endif; ?>

                                <?php if (session()->get('perfil_usuario') == 2 && $producto['id_estado'] == 1): ?>
                                <!-- Botón para dar de baja -->
                                <a href="<?= base_url('id_estado/' . $producto['id_producto'].'/0') ?>"
                                    class="btn btn-danger">Dar de baja</a>
                                <?php elseif (session()->get('perfil_usuario') == 2 && $producto['id_estado'] == 0): ?>
                                    <?php if ($producto['stock_producto'] > 0): ?>
                                        <!-- Si tiene stock, puede activar -->
                                        <a href="<?= base_url('id_estado/' . $producto['id_producto'].'/1') ?>" class="btn btn-success">Dar de alta</a>
                                    <?php else: ?>
                                        <!-- Si NO tiene stock, dirigir a editar -->
                                        <a href="<?= base_url('editar/' . $producto['id_producto']) ?>" class="btn btn-warning">Agregar Stock</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Enlaces de paginación -->
            <div class="container">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">

                        <?php 
                            // Detectar la URL base actual para mantener el filtro o categoría
                            $uri = current_url();
                        ?>

                        <?php if ($current_page > 1): ?>
                            <li class="page-item m-1">
                                <a class="page-link rounded-circle" 
                                href="<?= $uri . '?page=' . ($current_page - 1) ?>" 
                                aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?> m-1">
                                <a class="page-link rounded-circle" 
                                href="<?= $uri . '?page=' . $i ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages): ?>
                            <li class="page-item m-1">
                                <a class="page-link rounded-circle" 
                                href="<?= $uri . '?page=' . ($current_page + 1) ?>" 
                                aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>