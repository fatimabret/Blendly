<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\CategoriaModel;
use App\Models\ProductoModel;

class CategoriaController extends BaseController
{
    protected $helpers = ['url','form'];

    public function categorias($categoria_id = null, $orden = null)
    {
        $producto = new ProductoModel();
        $categoriaModel = new CategoriaModel();

        // Obtener todas las categorías
        $categorias = $categoriaModel->findAll();

        // Construir la consulta de productos
        $producto->select('producto.*, categoria.nombre_categoria')
                ->join('categoria', 'categoria.id_categoria = producto.categoria_producto');

        // Filtrar por categoría si se proporciona una categoría_id
        if ($categoria_id) {
            $producto->where('producto.categoria_producto', $categoria_id);
        }

        // Ordenar productos por precio si se especifica el orden
        if ($orden == 'asc') {
            $producto->orderBy('precio_producto', 'asc');
        } elseif ($orden == 'desc') {
            $producto->orderBy('precio_producto', 'desc');
        }

        // Ejecutar la consulta y obtener los productos con paginación
        $productos = $producto->paginate(4);
        $pager = $producto->pager;

        // Pasar datos a la vista
        $data = [
            'productos' => $productos,
            'categorias' => $categorias,
            'total_pages' => $pager,
            'titulo' => 'Productos'
        ];

        return view('plantilla/encabezado', $data)
            . view('plantilla/barra')
            . view('contenido/categorias', $data)
            . view('plantilla/footer');
    }

    public function mas_vendidos()
    {
        $producto = new ProductoModel();
        $categoriaModel = new CategoriaModel();

        // Obtener todas las categorías
        $categorias = $categoriaModel->findAll();

        // Obtener productos más vendidos con paginación
        $productos = $producto->orderBy('vendidos_producto', 'desc')
                            ->select('producto.*, categoria.nombre_categoria')
                            ->join('categoria', 'categoria.id_categoria = producto.categoria_producto')
                            ->where('vendidos_producto >', 0)
                            ->paginate(4);
        $pager = $producto->pager;

        // Pasar datos a la vista
        $data = [
            'productos' => $productos,
            'categorias' => $categorias,
            'total_pages' => $pager,
            'titulo' => 'Más Vendidos'
        ];

        return view('plantilla/encabezado', $data)
            . view('plantilla/barra')
            . view('contenido/categorias', $data)
            . view('plantilla/footer');
    }

    public function categorias_orden_alfabeto($orden)
    {
        $producto = new ProductoModel();
        $categoriaModel = new CategoriaModel();

        $categorias = $categoriaModel->findAll();

        $producto->select('producto.*, categoria.nombre_categoria')
                ->join('categoria', 'categoria.id_categoria = producto.categoria_producto')
                ->orderBy('nombre_producto', $orden) // asc o desc
                ->paginate(4); // Cantidad por página

        // Ordenar productos por precio si se especifica el orden
        if ($orden == 'asc') {
            $producto->orderBy('nombre_producto', 'asc');
        } elseif ($orden == 'desc') {
            $producto->orderBy('nombre_producto', 'desc');
        }

        $pager = $producto->pager;

        $data = [
            'productos' => $producto->findAll(),
            'categorias' => $categorias,
            'current_page' => $producto->pager->getCurrentPage(),
            'total_pages' => $pager,
            'titulo' => 'Productos'
        ];

        return view('plantilla/encabezado', $data)
            . view('plantilla/barra')
            . view('contenido/categorias', $data)
            . view('plantilla/footer');
    }

    public function categorias_orden_fecha($orden)
    {
        $producto = new ProductoModel();
        $categoriaModel = new CategoriaModel();

        $categorias = $categoriaModel->findAll();

        $producto->select('producto.*, categoria.nombre_categoria')
                ->join('categoria', 'categoria.id_categoria = producto.categoria_producto')
                ->orderBy('id_producto', $orden) // asc = más viejo, desc = más nuevo
                ->paginate(4); // Cantidad por página
        $pager = $producto->pager;

        $data = [
            'productos' => $producto->findAll(),
            'categorias' => $categorias,
            'current_page' => $producto->pager->getCurrentPage(),
            'total_pages' => $pager,
            'titulo' => 'Productos'
        ];

        return view('plantilla/encabezado', $data)
            . view('plantilla/barra')
            . view('contenido/categorias', $data)
            . view('plantilla/footer');
    }

    public function add_categoria() {
        $data['titulo'] = 'Agregar Categoría';

        return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('administrador/add_categoria')
            .view('plantilla/footer');
    }

    public function insertar_categoria() {
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        // Reglas de validación para el campo
        $validation->setRules(
            [
                'nombre_categoria' => 'required|max_length[50]|is_unique[categoria.nombre_categoria]'
            ],
            [   // Errors
                'nombre_categoria'=>[
                    'required' => 'El nombre de la categoria es obligatorio',
                    'max_length' => 'El nombre de la categoria no puede tener más de 50 caracteres',
                    'is_unique'=>'La categoria ya está registrada'
                ]
            ]
        );

        // Registra la categoria en la bd
        if ($validation->withRequest($request)->run()) {

            // Obtiene datos del formulario
            $data = [
                'nombre_categoria' => $request->getPost('nombre_categoria')
            ];

            // Inserta datos en la tabla de categorias
            $categoria = new CategoriaModel();
            $categoria->insert($data);

            // Mensaje de éxito
            return redirect()->route('add_categoria')->with('mensaje', 'Categoría registrada correctamente!');
        } else {
            $data['validation'] = $validation->getErrors();
            $data['titulo'] = 'Agregar Categoría';

            return view('plantilla/encabezado', $data)
                .view('plantilla/barra')
                .view('administrador/add_categoria', ['validation' => $validation])
                .view('plantilla/footer');
        }
    }
}