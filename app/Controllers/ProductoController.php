<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\ProveedorModel;

class ProductoController extends BaseController
{
    protected $helpers = ['url','form'];

    public function add_producto()
    {
        $validation = \Config\Services::validation();

        $producto_categoria = new CategoriaModel();
        $producto_proveedor = new ProveedorModel();

        $data['titulo'] = 'Registrar Producto';
        $data['producto_categoria'] = $producto_categoria->findAll();
        $data['producto_proveedor'] = $producto_proveedor->findAll();
        $data['validation'] = $validation;

        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('administrador/add_producto', $data)
        .view('plantilla/footer');
    }

    public function insertar_producto()
    {
        // Procesa los datos del producto enviados por el formulario
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules(
            [
                'nombre_producto' => 'required|max_length[50]',
                'proveedor_producto' => 'required',
                'descripcion_producto' => 'required|max_length[110]',
                'precio_producto' => 'required|max_length[10]',
                'imagen_producto' => 'uploaded[imagen_producto]|max_size[imagen_producto,4096]|is_image[imagen_producto]',
                'stock_producto' => 'required|max_length[3]',
                'categoria_producto' => 'required'
            ],
            [   // Errors
                'nombre_producto'=>[
                    'required' => 'El nombre es obligatorio',
                    'max_length' => 'El nombre no puede tener más de 50 caracteres'
                ],
                'proveedor_producto' => [
                    'required' => 'El proveedor es obligatorio'
                ],
                'descripcion_producto' => [
                    'required' => 'La descripcion es obligatorio',
                    'max_length' => 'La descripcion no puede tener más de 110 caracteres'
                ],
                'precio_producto' => [
                    'required' => 'El precio es obligatorio',
                    'max_length' => 'El precio no puede tener más de 10 unidades'
                ],
                'imagen_producto' => [
                    'uploaded' => 'Es obligatorio subir una imagen del producto',
                    'max_size' => 'La imagen del producto no debe exceder los 4MB',
                    'is_image' => 'El archivo subido debe ser una imagen válida'
                ],
                'stock_producto' => [
                    'required' => 'El stock es obligatorio',
                    'max_length' => 'El stock no puede tener más de 3 unidades'
                ],
                'categoria_producto' => [
                    'required' => 'La categoria es obligatoria'
                ]
            ]
        );

        if ($validation->withRequest($request)->run()) {
            $img = $request->getFile('imagen_producto');
            
            if ($img->isValid() && ! $img->hasMoved()) {
                $nombre = $img->getName();
                $nombre_imagen = time() . '_' . $nombre;
                
                $img->move(ROOTPATH . 'assets/img/producto', $nombre_imagen);

                $data = [
                    
                    'nombre_producto' => $request->getPost('nombre_producto'),
                    'proveedor_producto' => $request->getPost('proveedor_producto'),
                    'descripcion_producto' => $request->getPost('descripcion_producto'),
                    'precio_producto' => $request->getPost('precio_producto'),
                    'imagen_producto' => $nombre_imagen,
                    'stock_producto' => $request->getPost('stock_producto'),
                    'categoria_producto' => $request->getPost('categoria_producto'),
                    'id_estado' => 1
                ];

                $producto = new ProductoModel();
                $producto->insert($data);
                return redirect()->route('add_producto')->with('mensaje', 'El producto se registró correctamente!');
                
            } else {
                // Error al subir la imagen
                return redirect()->to('add_producto')->with('mensaje', 'Error al subir la imagen del producto.');
            }
        } else {
            $producto_categoria = new CategoriaModel();
            $producto_proveedor = new ProveedorModel();

            $data['titulo'] = "Registrar Producto";
            $data['producto_proveedor'] = $producto_proveedor->findAll();
            $data['producto_categoria'] = $producto_categoria->findAll();
            $data['validation'] = $validation;

            return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('administrador/add_producto', $data)
            .view('plantilla/footer');
        }

    }

    public function gestionar_prod()
    {
        $producto = new ProductoModel();

        // Obtener los productos y pasarlos a la vista
        $productos = $producto->join('categoria', 'categoria.id_categoria = producto.categoria_producto')
                              ->join('proveedor', 'proveedor.id_proveedor = producto.proveedor_producto')
                              ->findAll();

        $data['titulo'] = 'Gestionar Productos';
        $data['productos'] = $productos;

        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('administrador/gestionar_prod', $data)
        .view('plantilla/footer');
    }
    
    public function lista_producto()
    {
        $producto = new ProductoModel();
        $categoria = new CategoriaModel();

        // Obtener los productos y pasarlos a la vista
        $productos = $producto->join('categoria', 'categoria.id_categoria = producto.categoria_producto')
                              ->join('proveedor', 'proveedor.id_proveedor = producto.proveedor_producto')
                              ->findAll();

        $categorias = $categoria->findAll();

        $data['titulo'] = 'Productos y Categoria';
        $data['productos'] = $productos;
        $data['categorias'] = $categorias;

        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('administrador/lista_producto', $data)
        .view('plantilla/footer');
    }

    public function productos($page = 1)
    {
        $producto = new ProductoModel();
        $categoria = new CategoriaModel();
        
        $limit = 4; // Número de productos por página
        $offset = ($page - 1) * $limit;

        // Obtener el total de productos
        $total_productos = $producto->countAllResults();
        
        // Obtener los productos con límite y offset para la paginación
        $productos = $producto->join('categoria', 'categoria.id_categoria = producto.categoria_producto')
                              ->join('proveedor', 'proveedor.id_proveedor = producto.proveedor_producto')
                              ->limit($limit, $offset)
                              ->findAll();

        // Obtener todas las categorías
        $categorias = $categoria->findAll();

        // Calcular el número total de páginas
        $total_pages = ceil($total_productos / $limit);

        $data = [
            'productos' => $productos,
            'categorias' => $categorias,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'titulo' => 'Productos'
        ];

        return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('contenido/productos', $data)
            .view('plantilla/footer');
    }

    public function editar_producto($id = null)
    {
        $producto = new ProductoModel();
        $categoria = new CategoriaModel();
        $proveedor = new ProveedorModel();

        // Obtener el producto por ID
        $data['producto'] = $producto->find($id);
        
        // Obtener las categorías de productos
        $data['producto_categoria'] = $categoria->findAll();

        // Obtener los proveedores de productos
        $data['producto_proveedor'] = $proveedor->findAll();

        $data['titulo'] = 'Editar Producto';

        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('administrador/modificar_prod', $data)
        .view('plantilla/footer');
    }


    public function actualizar_producto()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $validation->setRules(
            [
                'nombre_producto' => 'required',
                'proveedor_producto' => 'required',
                'descripcion_producto' => 'required',
                'precio_producto' => 'required',
                'stock_producto' => 'required',
                'categoria_producto' => 'required'
            ],
            [
                'nombre_producto' => [
                    'required' => 'El nombre es obligatorio'
                ],
                'proveedor_producto' => [
                    'required' => 'El proveedor es obligatorio'
                ],
                'descripcion_producto' => [
                    'required' => 'La descripción es obligatoria'
                ],
                'precio_producto' => [
                    'required' => 'El precio es obligatorio'
                ],
                'stock_producto' => [
                    'required' => 'El stock es obligatorio'
                ],
                'categoria_producto' => [
                    'required' => 'La categoría es obligatoria'
                ]
            ]
        );

        if (!$validation->withRequest($this->request)->run()) {
            $producto = new ProductoModel();
            $categoria = new CategoriaModel();
            $proveedor = new ProveedorModel();

            // Obtener el producto, categorías y proveedores para pasarlos a la vista
            $data['producto'] = $producto->find($request->getPost('id'));
            $data['producto_categoria'] = $categoria->findAll();
            $data['producto_proveedor'] = $proveedor->findAll();

            $data['titulo'] = 'Editar Producto';
            $data['validation'] = $validation;

            return view('plantilla/encabezado', $data)
                . view('plantilla/barra')
                . view('administrador/modificar_prod', $data)
                . view('plantilla/footer');
        }

        $img = $request->getFile('imagen_producto');
        $id = $request->getPost('id');

        $data = [
            'nombre_producto' => $request->getPost('nombre_producto'),
            'proveedor_producto' => $request->getPost('proveedor_producto'),
            'descripcion_producto' => $request->getPost('descripcion_producto'),
            'precio_producto' => $request->getPost('precio_producto'),
            'stock_producto' => $request->getPost('stock_producto'),
            'categoria_producto' => $request->getPost('categoria_producto')
        ];

        // Verificar si se ha subido una nueva imagen
        if ($img->isValid() && !$img->hasMoved()) {
            $nombre = $img->getName();
            $nombre_imagen = time() . '_' . $nombre;
            $img->move(ROOTPATH . 'assets/img/producto', $nombre_imagen);
            $data['imagen_producto'] = $nombre_imagen;
        }

        $producto = new ProductoModel();
        $producto->update($id, $data);

        return redirect()->to('gestionar_prod')->with('mensaje', 'El producto se actualizó correctamente!');
    }

    public function estado_producto($id_producto, $estado)
    {
        $producto = new ProductoModel();
        $data = ['id_estado' => $estado];

        // Actualiza el estado del producto
        $producto->update($id_producto, $data);

        $mensaje = $estado == 0 ? 'Producto dado de baja exitosamente!' : 'Producto reactivado exitosamente!';
        return redirect()->back()->withInput()->with('mensaje', $mensaje);
    }

    public function buscar()
    {
        $query = $this->request->getGet('q');
        $producto = new ProductoModel();
        $categoria = new CategoriaModel();

        $productos = $producto
            ->select('producto.*, categoria.nombre_categoria')
            ->join('categoria', 'categoria.id_categoria = producto.categoria_producto')
            ->groupStart()
                ->like('producto.nombre_producto', $query)
                ->orLike('categoria.nombre_categoria', $query)
            ->groupEnd()
            ->paginate(4); // Cantidad por página

        $pager = \Config\Services::pager();
        $categorias = $categoria->findAll();

        $data = [
            'productos' => $productos,
            'categorias' => $categorias,
            'pager' => $pager,
            'titulo' => 'Resultados de búsqueda',
            'current_page' => $producto->pager->getCurrentPage(),
            'total_pages' => $producto->pager->getPageCount()
        ];

        return view('plantilla/encabezado', $data)
            . view('plantilla/barra')
            . view('contenido/productos', $data)
            . view('plantilla/footer');
    }

}
