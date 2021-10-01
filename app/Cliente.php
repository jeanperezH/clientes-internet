<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'id',
        'idSede',
        'tipoCliente',
        'tieneMiAntena',
        'deuda',
        'condicion'
    ];
    public $timestamps = false;
}
