<?php

namespace App\Models;
use CodeIgniter\Model;

class PedidoDetalleModel extends Model
{
    protected $table = 'pedido_detalle';   // nombre de la tabla
    protected $allowedFields = [
        'id_pedido',
        'id_producto',
        'cantidad_pedido',
        'precio_unitario'
    ];

    protected $returnType = 'array'; // retorno
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
