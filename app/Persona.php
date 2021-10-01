<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //protected $table = 'personas';
    protected $fillable = [
        'nombre',
        'celular',
        'fecha_registro',
        'fecha_cobros_pagos',
        'monto_mensual'
    ];
    public $timestamps = false;
}
