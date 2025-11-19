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
        $data['titulo'] = 'Carrito de compras';
        $data['productos'] = $cart->contents();

        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('contenido/carrito')
        .view('plantilla/footer');
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

    public function guardar_venta()
    {
        $cart = \Config\Services::cart();
        $venta = new PedidoModel();
        $detalle = new PedidoDetalleModel();
        $productos = new ProductoModel();
        $request = \Config\Services::request();
    
        //instancia el carrito en variable aux
        $cart1 = $cart->contents();

        // Verifica el stock de los productos
        foreach ($cart1 as $item)
        {
            //obtiene los datos del model
            $producto = $productos->where('id_producto', $item['id'])->first();

            if ($producto['stock_producto'] < $item['qty'] || $producto['stock_producto'] == 0)
            {
                return redirect()->route('carrito')->with('mensaje', '¡No hay Stock suficiente!');
            }
        }
    
        // Datos de la venta
        $data = array(
            'id_cliente' => session("id_usuario"),
            'fecha_pedido' => date('Y-m-d')
        );
    
        // Inserta la venta
        $id_venta = $venta->insert($data);

        // Detalles de la venta
        foreach ($cart1 as $item) {
            // Llamar a la función para actualizar el estado del producto si el stock es cero
            $this->actualizarStockProducto($item['id'], $item['qty']);

            $data = [
                "stock_producto" => $producto["stock_producto"] - $item['qty']
            ];

            $pedido_detalle = array(
                'id_pedido' => $id_venta,
                'id_producto' => $item['id'],
                'cantidad_pedido' => $item['qty'],
                'precio_unitario' => $item['price']
            );
    
            $productos->update($item['id'], $data);
    
            // Inserta el detalle de la venta
            $detalle->insert($pedido_detalle);
        }
    
        // Vacía el carrito
        $cart->destroy();
    
        return redirect()->route('carrito')->with('mensaje', '¡Gracias por su compra!');
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