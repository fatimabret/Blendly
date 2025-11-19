<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $helpers = ['url','form'];

    public function usuario($id_usuario = null)
    {
        $usuario = new UserModel();
        $data['usuario'] = $usuario->find($id_usuario);
        $data['titulo'] = 'Mi Perfil';

        return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('contenido/usuario', $data)
            .view('plantilla/footer');
    }

    public function mi_perfil()
    {
        $session = session();
        $id_usuario = $session->get('id_usuario');

        return $this->usuario($id_usuario); 
    }


//  ******** Gestion Administrador ********
    public function gestionar_user()
    {
        $usuario = new UserModel();
         $idUsuarioActivo = session('id_usuario'); // ID del usuario logueado

        // Trae todos los usuarios excepto el activo
        $data['clientes'] = $usuario
        ->where('id_usuario !=', $idUsuarioActivo)
        ->findAll();$data['titulo']='Gestionar Usuarios';

        return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('administrador/gestionar_user', $data)
            .view('plantilla/footer');
    }

    public function estado($id_usuario, $estado)
    {
        $usuario = new UserModel();
        $data = ['id_estado' => $estado];

        // Actualiza el estado del usuario
        $usuario->update($id_usuario, $data);

        if ($estado == 0 && session()->get('id_usuario') == $id_usuario) {
            session()->destroy();

            return redirect()->to('iniciarSesion')->with('mensaje', 'Tu cuenta esta desactivada! Mandanos una consulta (en contacto) para activar tu cuenta');
        }

        $mensaje = $estado == 0 ? 'Cuenta dada de baja exitosamente!' : 'Cuenta reactivada exitosamente!';
        return redirect()->back()->withInput()->with('mensaje', $mensaje);
    }

    public function actualizar_usuario()
    {
        $request = \Config\Services::request();
        $usuarioModel = new UserModel();

        $id = $request->getPost('id_usuario');
        $usuarioActual = $usuarioModel->find($id);

        // Datos a modificar siempre
        $data = [
            'nombre_usuario'   => $request->getPost('nombre_usuario'),
            'apellido_usuario' => $request->getPost('apellido_usuario'),
            'edad_usuario'     => $request->getPost('edad_usuario'),
            'correo_usuario'   => $request->getPost('correo_usuario')
        ];

        // VALIDACIÓN NOMBRE Y APELLIDO
        if (!preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/', $data['nombre_usuario'])) {
            return redirect()->back()->withInput()->with('mensaje', 'El nombre solo puede contener letras y espacios.');
        }

        if (!preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/', $data['apellido_usuario'])) {
            return redirect()->back()->withInput()->with('mensaje', 'El apellido solo puede contener letras y espacios.');
        }

        // Validar campos obligatorios
        if (empty($data['nombre_usuario']) || empty($data['apellido_usuario']) || empty($data['edad_usuario']) || empty($data['correo_usuario'])) {
            return redirect()->back()->withInput()->with('mensaje', 'Todos los campos son requeridos.');
        }

        // VALIDACIÓN Y CAMBIO DE CONTRASEÑA
        $currentPassword = $request->getPost('current_password');
        $newPassword = $request->getPost('new_password');
        $confirmPassword = $request->getPost('confirm_password');

        $camposPasswordCompletos = 
            !empty($currentPassword) &&
            !empty($newPassword) &&
            !empty($confirmPassword);

        // Si se completaron los 3 campos, recién ahí cambiamos contraseña
        if ($camposPasswordCompletos) {

            // Contraseña actual correcta
            if (!password_verify($currentPassword, $usuarioActual['pass_usuario'])) {
                return redirect()->back()->withInput()->with('mensaje', 'La contraseña actual no es correcta.');
            }

            // Nueva contraseña coincide
            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->withInput()->with('mensaje', 'La nueva contraseña y su confirmación no coinciden.');
            }

            // Guardar nueva contraseña
            $data['pass_usuario'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        // ACTUALIZAR DATOS DEL USUARIO
        $usuarioModel->update($id, $data);

        return redirect()->back()->with('mensaje', 'Perfil actualizado exitosamente.');
    }


    




//  ******** INICIAR SESION ********
    public function iniciar()
    {
        $data['titulo']='Iniciar Sesion';
        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('contenido/iniciarSesion')
        .view('plantilla/footer');
    }
    
    public function iniciar_sesion()
    {
        $session = session();
        // Instanciamos modelo
        $userModel = new UserModel();

        // Obtiene datos del formulario
        $correo = $this->request->getVar('correo_usuario');
        $pass = $this->request->getVar('pass_usuario');

        // Consulta
        $usuario = $userModel->where('correo_usuario', $correo)->first();

        if ($usuario) {
            $password = $usuario['pass_usuario'];
            $estado = $usuario['id_estado'];

            // Condicion estado de cuenta
            if ($estado == '0') {
                return redirect()->back()->withInput()->with('mensaje', 'Tu cuenta esta desactivada! Mandanos una consulta (en contacto) para activar tu cuenta');
            }

            // El usuario inicia sesión correctamente
            if (password_verify($pass, $password)) {
                $data = [
                    'id_usuario' => $usuario['id_usuario'],
                    'nombre_usuario' => $usuario['nombre_usuario'],
                    'apellido_usuario' => $usuario['apellido_usuario'],
                    'correo_usuario' => $usuario['correo_usuario'],
                    'perfil_usuario' => $usuario['perfil_usuario'],
                    'logged' => TRUE,
                ];
                $session->set($data);

                switch ($usuario['perfil_usuario']) {
                    case '1':
                        // Cliente
                        return redirect()->route('principal');
                    case '2':
                        // Administrador
                        return redirect()->route('principal');
                }
            } else {
                // Mensaje de error
                return redirect()->back()->withInput()->with('mensaje', 'Contraseña incorrecta.');
            }
        } else {
            // Mensaje de error
            return redirect()->back()->withInput()->with('mensaje', 'Correo incorrecto o no registrado.');
        }
    }
    
    public function cerrar_sesion()
    {
        $session = session();
        $session->destroy();
        
        return redirect()->to('/');
    }


//  ******** REGISTRAR USUARIO ********
    public function registrar()
    {
        $data['titulo']='Registrarte';
        return view('plantilla/encabezado', $data)
        .view('plantilla/barra')
        .view('contenido/registrar_cliente')
        .view('plantilla/footer');
    }
    
    public function add_cliente()
    {
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        // Reglas de validación para los campos
        $validation->setRules(
            [
                'nombre_usuario' => 'required|max_length[50]|regex_match[/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/]',
                'apellido_usuario' => 'required|max_length[50]|regex_match[/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/]',
                'edad_usuario' => 'required|integer',
                'correo_usuario'=>'required|valid_email|is_unique[usuario.correo_usuario]',
                'pass_usuario'=>'required|min_length[8]',
                'repass_usuario'=>'required|min_length[8]|matches[pass_usuario]'
            ],
            [   // Errors
                'nombre_usuario' => [
                    'required' => 'El nombre es obligatorio',
                    'regex_match' => 'El nombre solo puede contener letras y espacios'
                ],
                'apellido_usuario' => [
                    'required' => 'El apellido es obligatorio',
                    'regex_match' => 'El apellido solo puede contener letras y espacios'
                ],
                'edad_usuario' => [
                    'required'=>'La edad es obligatoria',
                    'integer' => 'La edad debe ser un número entero',
                ],
                'correo_usuario'=>[
                    'required'=>'El correo electrónico es obligatorio',
                    'valid_email'=>'La dirección de correo debe ser válida',
                    'is_unique'=>'Ese correo electrónico ya está siendo utilizado',
                ],
                'pass_usuario'=>[
                    'required'=>'La contraseña es obligatoria',
                    'min_length'=>'La contraseña debe tener como mínimo 8 caracteres',
                ],
                'repass_usuario'=>[
                    'required'=>'Repetir contraseña es obligatorio',
                    'min_length'=>'Repetir contraseña debe tener como mínimo 8 caracteres',
                    'matches'=>'Las contraseñas no coinciden',
                ],
            ]
        );

        // Registra al cliente en la bd
        if($validation->withRequest($request)->run()){

            // Obtiene datos del formulario
            $data=[
                'apellido_usuario'=>$request->getPost('apellido_usuario'),
                'nombre_usuario'=>$request->getPost('nombre_usuario'),
                'edad_usuario'=>$request->getPost('edad_usuario'),
                'correo_usuario'=>$request->getPost('correo_usuario'),
                'pass_usuario' => password_hash($request->getPost('pass_usuario'), PASSWORD_BCRYPT),
                'perfil_usuario'=>1, // Asigna perfil cliente
                'id_estado'=>1
            ];

            // Inserta datos en la tabla de usuarios
            $usuario = new UserModel();
            $usuario->insert($data);

            // Mensaje de éxito
            return redirect()->route('registrar_cliente')->with('mensaje', 'Perfil creado exitosamente!');
        } else {
            $data['titulo']='Registrarte';
            $data['validation']=$validation->getErrors();

            // Mensajes de error
            return view('plantilla/encabezado', $data)
            .view('plantilla/barra')
            .view('contenido/registrar_cliente', ['validation' => $validation])
            .view('plantilla/footer');
        }
    }
}

    