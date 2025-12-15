<?php

namespace App\Models;
use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table = 'pedido';   // nombre de la tabla
    protected $primaryKey = 'id_pedido'; // llave primaria
    protected $allowedFields = [
        // campo permitidos
    'fecha_pedido',
    'id_cliente',
    'nombre_cliente',
    'dni_cliente',
    'telefono_cliente',
    'metodo_pago',
    'notas'
    ];

    protected $returnType = 'array'; // retorno
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
