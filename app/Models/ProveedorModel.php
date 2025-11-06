<?php

namespace App\Models;
use CodeIgniter\Model;

class ProveedorModel extends Model
{
    protected $table = 'proveedor'; // nombre de la tabla
    protected $primaryKey = 'id_proveedor'; // llave primaria
    protected $allowedFields = [
        // campos permitidos
        'nombre_proveedor',
        'correo_proveedor',
        'telefono_proveedor'
    ];

    protected $returnType = 'array'; // retorno
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}