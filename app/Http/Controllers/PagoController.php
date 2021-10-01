<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $pagos=Pago::orderBy('id','asc')->paginate(4);
        }else{
            $pagos=Pago::where($criterio,'like','%'.$buscar.'%')
                                ->orderBy('id','desc')
                                ->paginate(3);
        }

        return[
            'pagination' => [
                'total'        => $pagos->total(),
                'current_page' => $pagos->currentPage(),
                'per_page'     => $pagos->perPage(),
                'last_page'    => $pagos->lastPage(),
                'from'         => $pagos->firstItem(),
                'to'           => $pagos->lastItem(),
            ],
            'pagos'=>$pagos
        ];
        
    }
}
