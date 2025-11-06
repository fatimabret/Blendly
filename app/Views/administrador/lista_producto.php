    <!-- Enlace para catalogo de productos -->
    <div class="text p-2">

        <h4 class="text-end me-5">
            <a href="<?php echo base_url('productos');?>" class="botones btn btn-light custom-link m-auto d-inline-block me-3 p-2">Catálogo de Productos</a>
        </h4>
    </div>
        <h1 class="display-3 text-center text-white m-2 pt-2 pb-2">Lista de Productos</h1>

    </main>

    <div class="container">
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
            <table id="mytable" class="table table-bordered tap
            ble-striped table-hover custom-table formulario small-table">
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
