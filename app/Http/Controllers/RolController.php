<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;

class RolController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $roles=Rol::orderBy('id','desc')->paginate(4);
        }else{
            $roles=Rol::where($criterio,'like','%'.$buscar.'%')
                                ->orderBy('id','desc')
                                ->paginate(4);
        }

        return[
            'pagination' => [
                'total'        => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page'     => $roles->perPage(),
                'last_page'    => $roles->lastPage(),
                'from'         => $roles->firstItem(),
                'to'           => $roles->lastItem(),
            ],
            'roles'=>$roles
        ];
        
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $roles = new Rol();
        $roles->rol=$request->rol;
        $roles->condicion='1';
        $roles->save();
         
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $roles = Rol::findOrFail($request->id);
        $roles->rol=$request->rol;
        //$roles->condicion='1';
        $roles->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $roles = Rol::findOrFail($request->id);
        $roles->condicion = '0';
        $roles->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $roles = Rol::findOrFail($request->id);
        $roles->condicion = '1';
        $roles->save();
    }

    public function selectRol(Request $request){
        if (!$request->ajax()) return redirect('/');

        $roles = Rol::select('id','rol')
        ->where('condicion','=','1')
        ->orderBy('rol','asc')->get();
        return ['roles'=>$roles];
    }
}
