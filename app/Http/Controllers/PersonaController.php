<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $personas=Persona::orderBy('id','asc')->paginate(4);
        }else{
            $personas=Persona::where($criterio,'like','%'.$buscar.'%')
                                ->orderBy('id','desc')
                                ->paginate(3);
        }

        return[
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas'=>$personas
        ];
        
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $personas = new Persona();
        $personas->nombres=$request->nombres;
        $personas->celular=$request->celular;
        $personas->fecha_registro=$request->fecha_registro;
        $personas->fecha_cobros_pagos=$request->fecha_cobros_pagos;
        $personas->monto_mensual=$request->monto_mensual;

        $personas->save();
         
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $roles = Rol::findOrFail($request->id);
        $personas->nombres=$request->nombres;
        $personas->celular=$request->celular;
        $personas->fecha_registro=$request->fecha_registro;
        $personas->fecha_cobros_pagos=$request->fecha_cobros_pagos;
        $personas->monto_mensual=$request->monto_mensual;
        $roles->save();
    }
}
