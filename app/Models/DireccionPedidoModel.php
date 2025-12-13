<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionPedidoModel extends Model
{
    protected $table = 'direccion_pedido';
    protected $primaryKey = 'id_direccion';

    protected $allowedFields = [
        'id_pedido',
        'calle',
        'numero',
        'piso',
        'ciudad',
        'provincia',
        'cp'
    ];
}
