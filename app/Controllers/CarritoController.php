<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use PSpell\Config;
use App\Models\PedidoDetalleModel;
use App\Models\PedidoModel;
use App\Models\ProductoModel;

//use App\Models\UserModel;

class CarritoController extends BaseController
{
    protected $helpers = ['url','form'];

    // CARRITO DE COMPRAS
    public function carrito()
    {
        $cart = \Config\Services::cart();
        $session = session();

        $usuario = null;

        if ($session->has('id_usuario')) {
            $userModel = new \App\Models\UserModel();
            $usuario = $userModel->find($session->get('id_usuario'));
        }

        $data = [
            'titulo' => 'Carrito de compras',
            'productos' => $cart->contents(),
            'usuario' => $usuario
        ];

        return view('plantilla/encabezado', $data)
            . view('plantilla/barra')
            . view('contenido/carrito', $data)
            . view('plantilla/footer');
    }

    public function add_carrito()
    {
        $cart = \Config\Services::cart();
        $request = \Config\Services::request();

        $productoModel = new ProductoModel();
        $idProducto = $request->getPost('id_producto');

        // Obtener producto desde BD
        $producto = $productoModel->find($idProducto);

        if (!$producto) {
            return redirect()->back()->with('mensaje', 'Producto no encontrado.');
        }

        $stockDisponible = $producto['stock_producto'];

        // Revisar cuánto del producto YA está en el carrito
        $cantidadEnCarrito = 0;
        foreach ($cart->contents() as $item) {
            if ($item['id'] == $idProducto) {
                $cantidadEnCarrito += $item['qty'];
            }
        }

        // Si ya llegó al tope del stock
        if ($cantidadEnCarrito >= $stockDisponible) {
            return redirect()->route('carrito')->with('mensaje', '¡No puedes agregar más unidades, llegaste al límite de stock!');
        }

        // Agregar 1 unidad
        $data = [
            'id' => $idProducto,
            'name' => $request->getPost('nombre_producto'),
            'price' => $request->getPost('precio_producto'),
            'qty' => 1
        ];

        $cart->insert($data);

        return redirect()->route('carrito')->with('mensaje', '¡El producto se agregó exitosamente!');
    }

    

    public function actualizarStockProducto($id_producto, $cantidad_producto)
    {
        $productoModel = new ProductoModel();

        // Obtener el producto actual
        $producto_actual = $productoModel->find($id_producto);

        // Calcular el nuevo stock
        $nuevo_stock = $producto_actual['stock_producto'] - $cantidad_producto;

        // Actualizar el stock del producto
        $productoModel->update($id_producto, ['stock_producto' => $nuevo_stock]);

        // Verificar y actualizar el estado del producto basado en el stock
        if ($nuevo_stock <= 0) {
            $productoModel->update($id_producto, ['id_estado' => 0]);
        }
    }

    public function borrar($rowid)
    {
        $cart = \Config\Services::cart();
        $cart->remove($rowid);
        return redirect()->route('carrito')->with('mensaje', 'Producto eliminado del carrito!');
    }

    public function vaciar()
    {
        $cart = \Config\Services::cart();
        $cart->destroy();
        return redirect()->route('carrito')->with('mensaje', 'Carrito vaciado!');
    }

    public function actualizarCantidad()
    {
        $cart = \Config\Services::cart();
        $request = \Config\Services::request();
        $productoModel = new ProductoModel();

        $accion = $request->getPost('accion'); 
        $rowid = $request->getPost('rowid');   

        $cartItems = $cart->contents();

        if (isset($cartItems[$rowid])) {

            $item = $cartItems[$rowid];
            $qtyActual = $item['qty'];
            $idProducto = $item['id'];

            // Buscar stock real del producto
            $producto = $productoModel->find($idProducto);
            $stockDisponible = $producto['stock_producto'];

            // Determinar nueva cantidad
            if ($accion === 'sumar') {

                if ($qtyActual + 1 > $stockDisponible) {
                    return redirect()->back()->with('mensaje', 'No puedes agregar más de lo disponible en stock.');
                }

                $qtyNueva = $qtyActual + 1;

            } elseif ($accion === 'restar' && $qtyActual > 1) {
                $qtyNueva = $qtyActual - 1;
            } else {
                $qtyNueva = $qtyActual;
            }

            // Actualizar carrito
            $cart->update([
                'rowid' => $rowid,
                'qty' => $qtyNueva
            ]);
        }

        return redirect()->to(base_url('carrito'));
    }

}