<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ConsultaModel;

class ConsultaController extends BaseController
{
    protected $helpers = ['url','form'];

    public function consulta()
    {
        $data['titulo']='Contacto';
        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('contenido/contacto')
        .view('plantilla/footer');
    }

    public function add_consulta()
    {
        
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        // Reglas de validacion para los campos
        $validation->setRules(
            [
                'texto_consulta'=>'required|max_length[150]',
                'motivo_consulta' => 'required|max_length[80]|regex_match[/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/]',
                'correo_consulta'=>'required|valid_email',
                'telefono_consulta' => 'required|min_length[10]|max_length[20]|regex_match[/^[0-9]+$/]',

            ],
            [   // Errors
                'correo_consulta'=>[
                    'required'=>'El correo es obligatorio',
                    'valid_email'=>'La dirección de correo debe ser válida',
                ],
                'telefono_consulta' => [
                    'required'   => 'El teléfono es obligatorio',
                    'min_length' => 'El teléfono debe tener como mínimo 10 caracteres',
                    'max_length' => 'El teléfono debe tener como máximo 20 caracteres',
                    'regex_match' => 'El teléfono solo puede contener números',
                ],
                'motivo_consulta'=>[
                    'required'=>'El motivo es obligatorio',
                    'min_length'=>'El motivo debe tener como mínimo 10 caracteres',
                    'max_length'=>'El motivo debe tener como máximo 80 caracteres',
                    'regex_match' => 'El motivo solo puede contener letras y espacios, no números ni símbolos',
                ],
                'texto_consulta'=>[
                    'required'=>'El mensaje es obligatorio',
                    'min_length'=>'El mensaje debe tener como mínimo 10 caracteres',
                    'max_length'=>'El mensaje debe tener como máximo 150 caracteres',
                ],
            ]
        );

        // Guarda consulta en la bd
        if($validation->withRequest($request)->run()){

            // Obtiene datos del formulario
            $data=[
                'correo_consulta'=>$request->getPost('correo_consulta'),
                'telefono_consulta'=>$request->getPost('telefono_consulta'),
                'motivo_consulta'=>$request->getPost('motivo_consulta'),
                'texto_consulta'=>$request->getPost('texto_consulta'),
                'leido_consulta'=>0,
            ];

            // Inserta datos en la tabla de consultas
            $userConsulta = new ConsultaModel();
            $userConsulta->insert($data);

            // Mensaje de éxito
            return redirect()->to('contacto')->with('mensaje', 'Su consulta se envió exitosamente!');

        } else {
            
            $data['titulo']='Contacto';
            $data['validation']=$validation->getErrors();

            // Mensajes de error
            return view('plantilla/encabezado', $data).
            view('plantilla/barra').
            view('contenido/contacto', ['validation' => $validation]).
            view('plantilla/footer');
        }
    }
    
    public function gestionar_consultas()
    {
        $consulta = new ConsultaModel();

        $dato['consulta'] = $consulta->findAll();
        $data['titulo'] = 'Listado de Consultas';

        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('administrador/lista_consulta', $dato)
        .view('plantilla/footer');
    }

    public function leido($id = null)
    {
        $consulta = new ConsultaModel();
        $consultaData = $consulta->find($id);

        if (!$consultaData) {
            return redirect()->to('lista_consulta')->with('mensaje', 'Consulta no encontrada.');
        }

        // Si ya fue respondida, no se puede marcar como no leída
        if (!empty($consultaData['respuesta_consulta'])) {
            return redirect()->to('lista_consulta')->with('mensaje', 'No se puede cambiar el estado: la consulta ya fue respondida.');
        }

        // Cambiar estado normalmente si no fue respondida
        $estado = $consultaData['leido_consulta'] == 0 ? 1 : 0;
        $consulta->update($id, ['leido_consulta' => $estado]);

        // Preparar el mensaje según el estado
        $mensaje = $estado == 1
            ? 'La consulta se marcó como leída correctamente.'
            : 'La consulta se marcó como no leída correctamente.';

        return redirect()->to('lista_consulta')->with('mensaje', $mensaje);
    }

    public function responder($id)
    {
        $request = \Config\Services::request();
        $consultaModel = new ConsultaModel();

        $respuesta = $request->getPost('respuesta_consulta');

        // Validar y asegurarte de que los datos están presentes
        if (!empty($respuesta)) {
            // Actualizar la consulta con la respuesta
            $data = [
                'respuesta_consulta' => $respuesta,
                'leido_consulta' => 1, // Se marca automáticamente como leída
            ];

            $consultaModel->update($id, $data);

            // Redirigir o mostrar un mensaje de éxito
            return redirect()->to(base_url('lista_consulta'))->with('mensaje', "Respuesta enviada!");
        } else {
            // Manejar caso de datos faltantes
            return redirect()->back()->with('mensaje', 'Error al procesar la respuesta. Inténtalo de nuevo más tarde.');
        }
    }

    public function listado_consultas($correo)
    {
        $consulta = new ConsultaModel();

        $data['consulta'] = $consulta->where('correo_consulta', $correo)->findAll();
        $data['titulo'] = 'Mis Consultas';
        
        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('contenido/consultas_view', $data)
        .view('plantilla/footer');
    }

    public function mis_consultas()
    {
        $session = session();
        $correo = $session->get('correo_usuario');

        return $this->listado_consultas($correo); 
    }
}
