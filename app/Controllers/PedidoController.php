<?php

namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\PedidoDetalleModel;
use App\Models\ProductoModel;

class PedidoController extends BaseController
{

// CLIENTE
    public function ver_detalles($id_pedido)
    {
        $ventas = new PedidoModel();
        $ventasDetalle = new PedidoDetalleModel();

        // Obtener datos de la venta, del cliente y del medio de pago
        $data['compras'] = $ventas->where('id_pedido', $id_pedido)
                        ->join('usuario', 'usuario.id_usuario = pedido.id_cliente')
                        ->first();
        
        // Obtener detalles de la venta y productos
        $data['compra_detalles'] = $ventasDetalle->where('id_pedido', $id_pedido)
                    ->join('producto', 'producto.id_producto = pedido_detalle.id_producto')
                    ->findAll();
        
        $data['titulo'] = "Mi Compra";

        return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('contenido/detalle_compras', $data)
            .view('plantilla/footer');
    }
    
    public function ver_compras($id_usuario)
    {
        $pedidoModel = new PedidoModel();
        $detalleVentaModel = new PedidoDetalleModel();

        $data = $pedidoModel->join('usuario', 'usuario.id_usuario = pedido.id_cliente')->find();
        // Obtener datos de la venta y del cliente
        $compras = $pedidoModel->where('id_cliente', $id_usuario)->findAll();

        // Calculamos el total de cada venta
        foreach ($compras as &$compra) {
            $detalles = $detalleVentaModel->where('id_pedido', $compra['id_pedido'])->findAll();
            $total = 0;
            foreach ($detalles as $detalle) {
                $total += $detalle['precio_unitario'] * $detalle['cantidad_pedido'];
            }
            $compra['total_venta'] = $total;
        }
        $data['compras'] = $compras;
        $data['titulo'] = "Mis Compras";
            
        return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('contenido/compras', $data)
            .view('plantilla/footer');
    }

    public function mi_compra()
    {
        $session = session();
        $id_usuario = $session->get('id_usuario');

        return $this->ver_compras($id_usuario); 
    }

    public function guardar_compra()
    {
        $cart = \Config\Services::cart();
        $pedidoModel = new \App\Models\PedidoModel();
        $detalleModel = new \App\Models\PedidoDetalleModel();
        $productoModel = new \App\Models\ProductoModel();
        $direccionModel = new \App\Models\DireccionPedidoModel(); // Crearás este model

        $request = service('request');

        // Validación backend
        $rules = [
            'nombre'   => 'required|regex_match[/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/]',
            'telefono' => 'required|numeric|min_length[6]|max_length[15]',
            'dni'      => 'required|numeric|min_length[7]|max_length[11]',
            'metodo'   => 'required',

            // Envío
            'calle'    => 'permit_empty|regex_match[/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$/]',
            'numero'   => 'permit_empty|numeric',
            'piso'     => 'permit_empty|alpha_numeric',
            'ciudad'   => 'permit_empty|regex_match[/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/]',
            'provincia'=> 'permit_empty|regex_match[/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/]',
            'cp'       => 'permit_empty|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('mensaje', 'Revisá los datos ingresados.');
        }

        $metodo = $request->getPost('metodo');

        // Verificar stock
        foreach ($cart->contents() as $item) {
            $prod = $productoModel->find($item['id']);
            if ($prod['stock_producto'] < $item['qty']) {
                return redirect()->back()->with('mensaje', 'Stock insuficiente para: ' . $prod['nombre_producto']);
            }
        }

        // Registrar pedido
        $dataPedido = [
            'id_cliente'   => session('id_usuario'),
            'nombre'       => $request->getPost('nombre'),
            'telefono'     => $request->getPost('telefono'),
            'dni'          => $request->getPost('dni'),
            'metodo'       => $metodo,
            'notas'        => $request->getPost('notas'),
            'fecha_pedido' => date('Y-m-d')
        ];

        $idPedido = $pedidoModel->insert($dataPedido);

        // Si es envío, registrar dirección
        if ($metodo === 'envio') {

            $direccionModel->insert([
                'id_pedido' => $idPedido,
                'calle'     => $request->getPost('calle'),
                'numero'    => $request->getPost('numero'),
                'piso'      => $request->getPost('piso'),
                'ciudad'    => $request->getPost('ciudad'),
                'provincia' => $request->getPost('provincia'),
                'cp'        => $request->getPost('cp')
            ]);
        }

        // Registrar detalles y actualizar stock
        foreach ($cart->contents() as $item) {

            // Insertar detalle
            $detalleModel->insert([
                'id_pedido'       => $idPedido,
                'id_producto'     => $item['id'],
                'cantidad_pedido' => $item['qty'],
                'precio_unitario' => $item['price']
            ]);

            // Descontar stock
            $productoModel->update($item['id'], [
                'stock_producto' => $productoModel->find($item['id'])['stock_producto'] - $item['qty']
            ]);
        }

        // Vaciar carrito
        $cart->destroy();

        return redirect()->to('carrito')->with('mensaje', 'Compra realizada con éxito.');
    }



// ADMINISTRADOR
    public function listar_ventas()
    {
        $data['titulo'] = 'Listado de Ventas'; 

        $ventasModel = new PedidoModel();
        $detalleVentaModel = new PedidoDetalleModel();

        $ventas = $ventasModel->join('usuario', 'usuario.id_usuario = pedido.id_cliente')->findAll();

        // Calculamos el total de cada venta
        foreach ($ventas as &$venta) {
            $detalles = $detalleVentaModel->where('id_pedido', $venta['id_pedido'])->findAll();
            $total = 0;
            foreach ($detalles as $detalle) {
                $total += $detalle['precio_unitario'] * $detalle['cantidad_pedido'];
            }
            $venta['total_venta'] = $total;
        }

        $data['pedidos'] = $ventas;

        return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('administrador/ventas', $data)
            .view('plantilla/footer');
    }

    public function listar_detalle_ventas($id = null)
    {
        $ventas = new PedidoModel();
        $ventasDetalle = new PedidoDetalleModel();

        // Obtener datos de la venta, del cliente y del medio de pago
        $data['pedidos'] = $ventas->where('id_pedido', $id)
                        ->join('usuario', 'usuario.id_usuario = pedido.id_cliente')
                        ->first();
        
        // Obtener detalles de la venta y productos
        $data['pedidos_detalles'] = $ventasDetalle->where('id_pedido', $id)
                    ->join('producto', 'producto.id_producto = pedido_detalle.id_producto')
                    ->findAll();
        
        $data['titulo'] = 'Lista Detalle Ventas';

        return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('administrador/detalle_ventas', $data)
            .view('plantilla/footer');
    }

            //return redirect()->back()->with('mensaje', 'Error al procesar el pedido. Inténtalo de nuevo más tarde.');

    public function buscar_ventas()
    {
        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');

        $data['titulo'] = 'Listado de Ventas';

        $ventasModel = new PedidoModel();
        $detalleVentaModel = new PedidoDetalleModel();

        // Buscar ventas por rango de fechas
        $ventas = $ventasModel
            ->join('usuario', 'usuario.id_usuario = pedido.id_cliente')
            ->where('fecha_pedido >=', $desde)
            ->where('fecha_pedido <=', $hasta)
            ->findAll();

        // Calcular totales
        foreach ($ventas as &$venta) {
            $detalles = $detalleVentaModel->where('id_pedido', $venta['id_pedido'])->findAll();
            $total = 0;
            foreach ($detalles as $detalle) {
                $total += $detalle['precio_unitario'] * $detalle['cantidad_pedido'];
            }
            $venta['total_venta'] = $total;
        }

        $data['pedidos'] = $ventas;

        return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('administrador/ventas', $data)
            .view('plantilla/footer');
    }
}
