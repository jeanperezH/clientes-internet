<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $fillable = [
        'idPersona',
        'idUsuario',
        'fecha_pago',
        'monto_pago',
        
    ];
    public $timestamps = false;
}
