    <!-- Enlace para catalogo de productos -->
    <div class="text p-2">

        <h4 class="text-end me-5">
            <a href="<?php echo base_url('productos');?>" class="botones btn btn-light custom-link m-auto d-inline-block me-3 p-2">Catálogo de Productos</a>
        </h4>
    </div>
        <h1 class="display-3 text-center text-white m-2 pt-2 pb-2">Lista de Productos</h1>

    </main>

    <div class="container">
        <nav class="navba1r m-0">
            <div class="container-fluid mt-3 mb-3 w-50">
                <form class="d-flex" action="<?= base_url('buscar_producto_admin') ?>" method="get">
                    <div class="col-md-1 text-center">
                        <a href="<?= base_url('lista_producto') ?>" title="Actualizar ventas">
                            <img 
                                src="<?= base_url('assets/img/icons/recarga.png') ?>" 
                                alt="Recargar"
                                style="width:32px; cursor:pointer;"
                            >
                        </a>
                    </div>
                    <input class="form-control me-2" type="search" name="q" placeholder="Nombre del producto o categoria" aria-label="Buscar">
                    <button type="submit" style="background: #1b243a;" class="btn btn-primary border -0">Buscar</button>
                </form>
            </div>
        </nav>

        <div class="table-responsive">
            <table id="mytable" class="table table-bordered table-striped table-hover custom-table formulario">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Proveedor</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($productos) && is_array($productos)) { ?>
                        <?php foreach($productos as $row) { ?>
                            <tr class="custom-row">
                                <td><?php echo $row['id_producto']; ?></td>
                                <td><?php echo $row['nombre_producto']; ?></td>
                                <td><?php echo $row['nombre_proveedor']; ?></td>
                                <td><?php echo $row['descripcion_producto']; ?></td>
                                <td>$<?php echo $row['precio_producto']; ?></td>
                                <td><img src="<?php echo base_url('assets/img/producto/' . $row['imagen_producto']); ?>" alt="Imagen del Producto" class="custom-image" /></td>
                                <td><?php echo $row['stock_producto']; ?></td>
                                <td><?php echo $row['nombre_categoria']; ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr class="custom-empty-row">
                            <td colspan="8" class="text-center">No hay productos registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <br>
    </div>

    <div class="container">

        <h1 class="display-3 text-center text-white m-2 pt-2 pb-2">Lista de Categorías</h1>
        
        <div class="table-responsive">
            <table id="mytable" class="table table-bordered tapble-striped table-hover custom-table formulario small-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categorias) && is_array($categorias)) { ?>
                        <?php foreach($categorias as $row) { ?>
                            <tr class="custom-row">
                                <td><?php echo $row['nombre_categoria']; ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr class="custom-empty-row">
                            <td colspan="1" class="text-center">No hay categorías registradas.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
