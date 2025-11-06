<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponsableInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        //Si el usuario no esta logeado o si no es usuario administrador
        if((!session()->get('logged')) || (session()->get('perfil_usuario') != 2)){

            //Redirecciona a la página de login page
            return redirect()->to('principal');
        }
    }

    //-------------------------------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //algo
    }
}