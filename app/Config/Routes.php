<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// Rutas Públicas

$routes->get('/', 'Home::index');
$routes->get('principal', 'Home::index');
$routes->get('quieneSomos', 'Home::quienes_somos');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('terminosUsos', 'Home::terminos_usos');

// Rutas para productos
$routes->get('productos', 'ProductoController::productos');
$routes->get('productos/(:num)', 'ProductoController::productos/$1');
$routes->get('producto/buscar', 'ProductoController::buscar');

// Rutas para categorías
$routes->get('categorias/categoria/(:num)', 'CategoriaController::categorias/$1');
$routes->get('categorias/orden/(:alpha)', 'CategoriaController::categorias/0/$1');
$routes->get('categorias/mas_vendidos', 'CategoriaController::mas_vendidos');
$routes->get('categorias/orden/alfabeto/(:alpha)', 'CategoriaController::categorias_orden_alfabeto/$1');
$routes->get('categorias/orden/fecha/(:alpha)', 'CategoriaController::categorias_orden_fecha/$1');

// Rutas para consulta
$routes->get('contacto', 'ConsultaController::consulta');
$routes->post('contacto', 'ConsultaController::add_consulta');


// Registro y Autenticación

$routes->group('', function ($routes) {
    $routes->get('registrar_cliente', 'UserController::registrar');
    $routes->post('registrar_cliente', 'UserController::add_cliente');

    $routes->get('iniciarSesion', 'UserController::iniciar');
    $routes->post('iniciarSesion', 'UserController::iniciar_sesion');
});


// Usuario Registrado (no redirecciona a principal)

$routes->group('', ['filter' => 'registered'], function ($routes) {
    $routes->get('cerrar_sesion', 'UserController::cerrar_sesion');
    $routes->get('mi_perfil', 'UserController::mi_perfil');
    $routes->get('usuario/(:num)', 'UserController::usuario/$1');
    $routes->post('actualizar_usuario', 'UserController::actualizar_usuario');

    // Consultas del cliente
    $routes->get('mis_consultas', 'ConsultaController::mis_consultas');

    // Carrito
    $routes->get('carrito', 'CarritoController::carrito');
    $routes->post('add_carrito', 'CarritoController::add_carrito');
    $routes->get('quitar/(:any)', 'CarritoController::borrar/$1');
    $routes->get('vaciar', 'CarritoController::vaciar');
    $routes->post('actualizar_cantidad', 'CarritoController::actualizarCantidad');

    // Compras del cliente
    $routes->get('mi_compra', 'PedidoController::mi_compra');
    $routes->get('compras/(:num)', 'PedidoController::ver_compras/$1');
    $routes->get('detalle_compra/(:num)', 'PedidoController::ver_detalles/$1');
    $routes->post('guardar_compra', 'PedidoController::guardar_compra');

    // Detalle de ventas
    $routes->get('ventas', 'PedidoController::listar_ventas');
    $routes->get('detalle_ventas/(:num)', 'PedidoController::listar_detalle_ventas/$1');
});


// Administración (Perfil = 2)

$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Gestión de usuarios
    $routes->get('gestionar_user', 'UserController::gestionar_user');
    $routes->get('id_estado/(:num)/(:num)', 'UserController::estado/$1/$2');

    // Categorías
    $routes->get('add_categoria', 'CategoriaController::add_categoria');
    $routes->post('insertar_categoria', 'CategoriaController::insertar_categoria');

    // Productos
    $routes->get('add_producto', 'ProductoController::add_producto');
    $routes->post('agregar_producto', 'ProductoController::insertar_producto');
    $routes->get('editar/(:num)', 'ProductoController::editar_producto/$1');
    $routes->post('actualizar', 'ProductoController::actualizar_producto');
    $routes->get('gestionar_prod', 'ProductoController::gestionar_prod');
    $routes->get('lista_producto', 'ProductoController::lista_producto');
    $routes->get('estado_producto/(:num)/(:num)', 'ProductoController::estado_producto/$1/$2');
    $routes->get('buscar_producto_admin', 'ProductoController::buscar_admin');
    $routes->get('buscar_gestion', 'ProductoController::buscar_gestion');

    // Proveedores
    $routes->get('add_proveedor', 'ProveedorController::add_proveedor');
    $routes->post('insertar_proveedor', 'ProveedorController::insertar_proveedor');
    $routes->get('lista_proveedor', 'ProveedorController::lista_proveedor');

    // Consultas
    $routes->get('lista_consulta', 'ConsultaController::gestionar_consultas');
    $routes->get('consulta/leido/(:num)', 'ConsultaController::leido/$1');
    $routes->post('consulta/responder/(:num)', 'ConsultaController::responder/$1');

    // Pedidos
    $routes->get('ventas/buscar', 'PedidoController::buscar_ventas');
});