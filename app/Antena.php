<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antena extends Model
{
    //protected $table = 'antenas';
    protected $fillable = [
        'idCliente',
        'fecha_entrega',
        'estado',
        
    ];
    public $timestamps = false;
}
