<?php

namespace App\Controllers;

use App\Models\ProveedorModel;
use CodeIgniter\Controller;

class ProveedorController extends BaseController
{
    protected $helpers = ['url','form'];

    public function add_proveedor() {
        $data['titulo'] = 'Agregar Proveedor';

        return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('administrador/add_proveedor')
            .view('plantilla/footer');
    }

    public function lista_proveedor()
    {
        $proveedor = new ProveedorModel();

        $proveedores = $proveedor->findAll();

        $data['titulo'] = 'Lista de Prveedores';
        $data['proveedores'] = $proveedores;

        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('administrador/lista_proveedor', $data)
        .view('plantilla/footer');
    }

    public function insertar_proveedor() {
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        // Reglas de validación para el campo
        $validation->setRules(
            [
                'nombre_proveedor' => 'required|max_length[50]',
                'correo_proveedor' => 'required|valid_email|is_unique[proveedor.correo_proveedor]',
                'telefono_proveedor' => 'required|max_length[20]|min_length[8]'
            ],
            [   // Errors
                'nombre_proveedor'=>[
                    'required' => 'El nombre es obligatorio',
                    'max_length' => 'El nombre no puede tener más de 50 caracteres'
                ],
                'correo_proveedor'=>[
                    'required'=>'El correo electrónico es obligatorio',
                    'valid_email'=>'La dirección de correo debe ser válida',
                    'is_unique'=>'Ese correo electrónico ya está registrado',
                ],
                'telefono_proveedor'=>[
                    'required'=>'El telefono es obligatorio',
                    'min_length'=>'El teléfono del proveedor debe tener como mínimo 8 caracteres'
                ]
            ]
        );

        // Registra la categoria en la bd
        if ($validation->withRequest($request)->run()) {

            // Obtiene datos del formulario
            $data = [
                'nombre_proveedor' => $request->getPost('nombre_proveedor'),
                'correo_proveedor'=>$request->getPost('correo_proveedor'),
                'telefono_proveedor'=>$request->getPost('telefono_proveedor')
            ];

            // Inserta datos en la tabla de categorias
            $proveedor = new ProveedorModel();
            $proveedor->insert($data);

            // Mensaje de éxito
            return redirect()->route('add_proveedor')->with('mensaje', 'Proveedor registrado correctamente!');
        } else {
            $data['validation'] = $validation->getErrors();
            $data['titulo'] = 'Agregar Proveedor';

            // Mensajes de error
            return view('plantilla/encabezado', $data)
                .view('plantilla/barra')
                .view('administrador/add_proveedor', ['validation' => $validation])
                .view('plantilla/footer');
        }
    }
}