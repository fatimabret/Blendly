<?php

namespace App\Models;
use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table = 'categoria'; // nombre de la tabla
    protected $primaryKey = 'id_categoria'; // llave primaria
    protected $allowedFields = [
        // campos permitidos
        'nombre_categoria'
    ];

    protected $returnType = 'array'; // retorno
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}