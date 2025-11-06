<?php

namespace App\Controllers;
use App\Models\ProductoModel;

class Home extends BaseController
{
    public function index()
    {
        $productoModel = new ProductoModel();

        // Recuperar los últimos productos con su categoría
        $ultimosProductos = $productoModel->join('categoria', 'categoria.id_categoria = producto.categoria_producto')
                            ->orderBy('producto.id_producto', 'DESC')
                            ->limit(3)
                            ->findAll();

        // Recuperar los dos productos mas vendidos
        $vendidosProductos = $productoModel->select('producto.*, categoria.nombre_categoria')
                            ->join('categoria', 'categoria.id_categoria = producto.categoria_producto')
                            ->orderBy('vendidos_producto', 'desc')
                            ->limit(2)
                            ->findAll();

        $data = [
            'titulo' => 'Blendly',
            'ultimosProductos' => $ultimosProductos,
            'vendidosProductos' => $vendidosProductos
        ];
        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('contenido/principal', $data)
        .view('plantilla/footer');
    }

    public function contacto()
    {
        $data['titulo'] = 'Contacto';
        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('contenido/contacto')
        .view('plantilla/footer');
    }

    public function quienes_somos()
    {
        $data['titulo'] = '¿Quienes Somos?';
        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('contenido/quieneSomos')
        .view('plantilla/footer');
    }

    public function comercializacion()
    {
        $data['titulo'] = 'Comercializaciòn';
        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('contenido/comercializacion')
        .view('plantilla/footer');
    }
    
    public function productos()
    {
        $data['titulo'] = 'Productos';
        return view('plantilla/encabezado', $data)
        .view('plantilla/barra').view('contenido/productos')
        .view('plantilla/footer');
    }

    public function terminos_usos()
    {
        $data['titulo'] = 'Terminos y Usos';
        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('contenido/terminosUsos')
        .view('plantilla/footer');
    }
}
