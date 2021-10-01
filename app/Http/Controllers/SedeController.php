<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sede;

class SedeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $sedes=Sede::orderBy('id','desc')->paginate(4);
        }else{
            $sedes=Sede::where($criterio,'like','%'.$buscar.'%')
                                ->orderBy('id','desc')
                                ->paginate(4);
        }

        return[
            'pagination' => [
                'total'        => $sedes->total(),
                'current_page' => $sedes->currentPage(),
                'per_page'     => $sedes->perPage(),
                'last_page'    => $sedes->lastPage(),
                'from'         => $sedes->firstItem(),
                'to'           => $sedes->lastItem(),
            ],
            'sedes'=>$sedes
        ];
        
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sedes = new Sede();
        $sedes->sede=$request->sede;
        $sedes->save();
         
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $sedes = Sede::findOrFail($request->id);
        $sedes->sede=$request->sede;
        $sedes->save();
    }

    public function selectSede(Request $request){
        if (!$request->ajax()) return redirect('/');

        $sedes = Sede::select('id','sede')->orderBy('id','desc')->get();
        return ['sedes'=>$sedes];
    }
}
