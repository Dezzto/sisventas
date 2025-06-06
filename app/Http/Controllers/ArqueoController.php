<?php

namespace App\Http\Controllers;

use App\Models\Arqueo;
use App\Models\Empresa;
use App\Models\MovimientoCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ArqueoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        // Si el usuario está autenticado, obtener la empresa y compartirla en la vista
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                // Obtener la empresa según el id de la empresa del usuario autenticado
                $empresa = Empresa::find(Auth::user()->empresa_id);
                // Compartir la variable 'empresa' con todas las vistas
                view()->share('empresa', $empresa);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $arqueoAbierto = Arqueo::whereNull('fecha_cierre')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->first();
        $arqueos = Arqueo::with('movimientos')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->get();

        foreach ($arqueos as $arqueo){
            $arqueo->total_ingresos = $arqueo->movimientos->where('tipo','INGRESO')->sum('monto');
            $arqueo->total_egresos = $arqueo->movimientos->where('tipo','EGRESO')->sum('monto');
        }

        return view('admin.arqueos.index',compact('arqueos','arqueoAbierto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.arqueos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$datos = request()->all();
        //return response()->json($datos);
        $request->validate([
            'fecha_apertura'=>'required',
        ]);

        $arqueo = new Arqueo();

        $arqueo->fecha_apertura = $request->fecha_apertura;
        $arqueo->monto_inicial = $request->monto_inicial;
        $arqueo->descripcion = $request->descripcion;

        $arqueo->empresa_id = Auth::user()->empresa_id;

        $arqueo->save();

        return redirect()->route('admin.arqueos.index')
            ->with('mensaje','Se registro el arqueo de la manera correcta')
            ->with('icono','success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $arqueo = Arqueo::find($id)->first();
        $movimientos = MovimientoCaja::where('arqueo_id',$id)->get();
        return view('admin.arqueos.show',compact('arqueo','movimientos'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Arqueo $arqueo, $id)
    {
        $arqueo = Arqueo::find($id)->first();
        return view('admin.arqueos.edit',compact('arqueo'));
    }

    public function ingresoegreso($id){
        $arqueo = Arqueo::find($id);
        return view('admin.arqueos.ingreso-egreso',compact('arqueo'));
    }

    public function store_ingresos_egresos(Request $request){
       // $datos = request()->all();
        //return response()->json($datos);
        $request->validate([
            'monto'=>'required',
        ]);

        $movimiento = new MovimientoCaja();
        $movimiento->tipo = $request->tipo;
        $movimiento->monto = $request->monto;
        $movimiento->descripcion = $request->descripcion;
        $movimiento->arqueo_id = $request->id;
        $movimiento->save();

        return redirect()->route('admin.arqueos.index')
            ->with('mensaje','Se registro el movimiento de la manera correcta')
            ->with('icono','success');

    }

    public function cierre($id){
        $arqueo = Arqueo::find($id);
        return view('admin.arqueos.cierre',compact('arqueo'));
    }

    public function store_cierre(Request $request){
        //$datos = request()->all();
        //return response()->json($datos);
        $arqueo = Arqueo::find($request->id);
        $arqueo->fecha_cierre = $request->fecha_cierre;
        $arqueo->monto_final = $request->monto_final;
        $arqueo->save();

        return redirect()->route('admin.arqueos.index')
            ->with('mensaje','Se registro el cierre de la manera correcta')
            ->with('icono','success');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //$datos = request()->all();
        //return response()->json($datos);
        $request->validate([
            'fecha_apertura'=>'required',
        ]);

        $arqueo = Arqueo::find($id);

        $arqueo->fecha_apertura = $request->fecha_apertura;
        $arqueo->monto_inicial = $request->monto_inicial;
        $arqueo->descripcion = $request->descripcion;

        $arqueo->empresa_id = Auth::user()->empresa_id;

        $arqueo->save();

        return redirect()->route('admin.arqueos.index')
            ->with('mensaje','Se modifico el arqueo de la manera correcta')
            ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Arqueo::destroy($id);
        return redirect()->route('admin.arqueos.index')
            ->with('mensaje','Se elimino el arqueo de la manera correcta')
            ->with('icono','success');
    }

    public function reporte(){

        $empresa = Empresa::where('id',Auth::user()->empresa_id)->first();

        $arqueos = Arqueo::with('movimientos')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->get();

        foreach ($arqueos as $arqueo){
            $arqueo->total_ingresos = $arqueo->movimientos->where('tipo','INGRESO')->sum('monto');
            $arqueo->total_egresos = $arqueo->movimientos->where('tipo','EGRESO')->sum('monto');
        }

        $pdf = PDF::loadView('admin.arqueos.reporte',compact('arqueos','empresa'))
            ->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
