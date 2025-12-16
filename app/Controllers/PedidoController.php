<?php

namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\PedidoDetalleModel;
use App\Models\ProductoModel;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        $generarPDF = $this->request->getPost('generar_pdf') == '1';
        $cart = \Config\Services::cart();
        $db = \Config\Database::connect();

        $pedidoModel   = new \App\Models\PedidoModel();
        $detalleModel  = new \App\Models\PedidoDetalleModel();
        $productoModel = new \App\Models\ProductoModel();
        $direccionModel = new \App\Models\DireccionPedidoModel();

        $request = service('request');

        // VALIDACIONES
        $rules = [
            'nombre'   => 'required|regex_match[/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/]',
            'telefono' => 'required|numeric|min_length[6]|max_length[15]',
            'dni'      => 'required|numeric|min_length[7]|max_length[11]',
            'metodo'   => 'required|in_list[retiro,envio]',

            'calle'     => 'permit_empty|max_length[150]',
            'numero'    => 'permit_empty|numeric|max_length[10]',
            'piso'      => 'permit_empty|max_length[20]',
            'ciudad'    => 'permit_empty|regex_match[/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/]',
            'provincia' => 'permit_empty|regex_match[/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/]',
            'cp'        => 'permit_empty|numeric|min_length[3]|max_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('mensaje', 'Revisá los datos ingresados.');
        }

        if (empty($cart->contents())) {
            return redirect()->to('carrito')->with('mensaje', 'El carrito está vacío.');
        }

        // INICIAR TRANSACCIÓN
        $db->transBegin();

        try {

            // VERIFICAR STOCK
            foreach ($cart->contents() as $item) {
                $producto = $productoModel->find($item['id']);

                if (!$producto || $producto['stock_producto'] < $item['qty']) {
                    throw new \Exception('Stock insuficiente para ' . $item['name']);
                }
            }

            // CREAR PEDIDO
            $idPedido = $pedidoModel->insert([
                'id_cliente'   => session('id_usuario'),
                'nombre_cliente'       => $request->getPost('nombre'),
                'telefono_cliente'     => $request->getPost('telefono'),
                'dni_cliente'          => $request->getPost('dni'),
                'metodo'       => $request->getPost('metodo'),
                'metodo_pago'  => $request->getPost('metodo_pago'),
                'notas'        => $request->getPost('notas'),
                'fecha_pedido' => date('Y-m-d H:i:s')
            ]);


            // DIRECCIÓN (solo envío)
            if ($request->getPost('metodo') === 'envio') {
                $direccionModel->insert([
                    'id_pedido' => $idPedido,
                    'calle'     => $request->getPost('calle'),
                    'numero'    => $request->getPost('numero'),
                    'piso' => $request->getPost('piso'),
                    'ciudad'    => $request->getPost('ciudad'),
                    'provincia' => $request->getPost('provincia'),
                    'cp'        => $request->getPost('cp')
                ]);
            }

            // DETALLES + STOCK
            foreach ($cart->contents() as $item) {

                $producto = $productoModel->find($item['id']);
                $nuevoStock = $producto['stock_producto'] - $item['qty'];

                $detalleModel->insert([
                    'id_pedido'       => $idPedido,
                    'id_producto'     => $item['id'],
                    'cantidad_pedido' => $item['qty'],
                    'precio_unitario' => $item['price']
                ]);

                $productoModel->update($item['id'], [
                    'stock_producto' => $nuevoStock
                ]);
            }

            $db->transCommit();
            // Vaciar carrito
            $cart->destroy();

            // Generar PDF
            if ($generarPDF) {
                return redirect()->to(base_url('pedido/pdf/' . $idPedido));
            }

            // NO quiere PDF
            return redirect()->to('principal')
                            ->with('compra_exitosa', true)
                            ->with('mensaje', 'Compra realizada con éxito.');

        } catch (\Exception $e) {

            $db->transRollback();
            return redirect()->back()->with('mensaje', $e->getMessage());
        }
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

    public function generarPDF($idPedido)
    {
        $pedidoModel  = new PedidoModel();
        $detalleModel = new PedidoDetalleModel();

        $pedido   = $pedidoModel->find($idPedido);

        $detalles = $detalleModel
            ->select('producto.nombre_producto AS producto,
                    pedido_detalle.cantidad_pedido AS cantidad,
                    pedido_detalle.precio_unitario AS precio',)
            ->join('producto', 'producto.id_producto = pedido_detalle.id_producto')
            ->where('pedido_detalle.id_pedido', $idPedido)
            ->findAll();

        $total = 0;

        foreach ($detalles as $d) {
            $total += $d['cantidad'] * $d['precio'];
        }

        $html = view('contenido/comprobante_pdf', [
            'pedido'   => $pedido,
            'detalles' => $detalles,
            'total'    => $total
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setContentType('application/pdf')
            ->setBody($dompdf->output());
    }

}
