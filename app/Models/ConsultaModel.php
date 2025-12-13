<?php

namespace App\Models;
use CodeIgniter\Model;

class ConsultaModel extends Model
{
    protected $table = 'consulta'; // nombre de la tabla
    protected $primaryKey = 'id_consulta'; // llave primaria
    protected $allowedFields = [
        // campos permitidos
        'correo_consulta',
        'telefono_consulta',
        'motivo_consulta',
        'texto_consulta',
        'id_usuario',
        'leido_consulta',
        'respuesta_consulta'
    ];

    protected $returnType = 'array'; // retorno
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
    protected $useAutoIncrement = true;
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
}
