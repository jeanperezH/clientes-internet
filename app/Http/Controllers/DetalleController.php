<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detalle;

class DetalleController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $detalles=Detalle::orderBy('id','asc')->paginate(4);
        }else{
            $detalles=Detalle::where($criterio,'like','%'.$buscar.'%')
                                ->orderBy('id','desc')
                                ->paginate(3);
        }

        //$detalles = Detalle::paginate(2);
        return[
            'pagination' => [
                'total'        => $detalles->total(),
                'current_page' => $detalles->currentPage(),
                'per_page'     => $detalles->perPage(),
                'last_page'    => $detalles->lastPage(),
                'from'         => $detalles->firstItem(),
                'to'           => $detalles->lastItem(),
            ],
            'detalles'=>$detalles
        ];
        
    }
}
