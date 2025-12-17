<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ConsultaModel;

class ConsultaController extends BaseController
{
    protected $helpers = ['url','form'];

    public function consulta()
    {
        $session = session();
        $usuario = null;

        if ($session->has('id_usuario')) {
            $userModel = new \App\Models\UserModel();
            $usuario = $userModel->find($session->get('id_usuario'));
        }

        $data = [
            'titulo' => 'Contacto',
            'usuario' => $usuario,
            'validation' => \Config\Services::validation()
        ];

        return view('plantilla/encabezado', $data)
            . view('plantilla/barra')
            . view('contenido/contacto', $data)
            . view('plantilla/footer');
    }
    
    public function add_consulta()
    {
        $session = session();
        $userModel = new \App\Models\UserModel();

        // Obtener correo y teléfono del formulario o sesión
        if ($session->has('correo_usuario')) {
            // Usuario logueado
            $correo = $session->get('correo_usuario');

            $usuario = $userModel->where('correo_usuario', $correo)->first();
            $telefono = $usuario['telefono_usuario'] ?? null;
            $idUsuario = $usuario['id_usuario'] ?? null;
        } else {
            // Invitado
            $correo   = $this->request->getPost('correo_consulta');
            $telefono = $this->request->getPost('telefono_consulta');
            $idUsuario = null;
        }

        // Validación
        $validation = \Config\Services::validation();
        $validation->setRules([
            'motivo_consulta' => 'required|max_length[100]|regex_match[/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/]',
            'texto_consulta'  => 'required|max_length[500]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // Insertar consulta
        $consultaModel = new \App\Models\ConsultaModel();
        $data = [
            'correo_consulta'   => $correo,
            'telefono_consulta' => $telefono,
            'motivo_consulta'   => $this->request->getPost('motivo_consulta'),
            'texto_consulta'    => $this->request->getPost('texto_consulta'),
            'id_usuario'        => $idUsuario
        ];

        $consultaModel->insert($data);

        return redirect()->back()->with('mensaje', 'Tu consulta fue enviada correctamente.');
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
            return redirect()->to('lista_consulta')
                ->with('mensaje', 'Consulta no encontrada.');
        }

        // Bloquear para consultas de usuarios NO registrados
        if (!isset($consultaData['id_usuario']) || $consultaData['id_usuario'] === null) {
            return redirect()->to('lista_consulta')
                ->with('mensaje', 'No se puede modificar el estado: el remitente no está registrado.');
        }

        // Si ya fue respondida, no se puede cambiar estado
        if (!empty($consultaData['respuesta_consulta'])) {
            return redirect()->to('lista_consulta')
                ->with('mensaje', 'No se puede cambiar el estado: la consulta ya fue respondida.');
        }

        // Cambiar estado normalmente
        $estado = $consultaData['leido_consulta'] == 0 ? 1 : 0;
        $consulta->update($id, ['leido_consulta' => $estado]);

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
