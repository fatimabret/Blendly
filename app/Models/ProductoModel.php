<?php

namespace App\Models;
use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'producto'; // Tabla
    protected $primaryKey = 'id_producto'; // llave primaria
    protected $allowedFields = [
        // campos permitidos
        'categoria_producto',
        'nombre_producto',
        'descripcion_producto',
        'precio_producto',
        'stock_producto',
        'imagen_producto',
        'id_estado',
        'proveedor_producto',
        'vendidos_producto'
    ];

    protected $returnType = 'array'; // retorno
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}