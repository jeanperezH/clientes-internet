<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    protected $table = 'cobros';
    protected $fillable = [
        'idCliente',
        'idUsuario',
        'fecha_cobro',
        'monto_cobro',
        'tipo_cobro'
    ];
    public $timestamps = false;
}
