<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'usuario';   // nombre de la tabla
    protected $primaryKey = 'id_usuario'; // llave primaria
    protected $allowedFields = [
        // campos permitidos
        'nombre_usuario',
        'apellido_usuario',
        'edad_usuario',
        'correo_usuario',
        'pass_usuario',
        'perfil_usuario',
        'estado_usuario'
    ];

    protected $returnType = 'array'; // retorno
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
    protected bool $updateOnlyChanged = true;
    protected $useAutoIncrement = true;
}
