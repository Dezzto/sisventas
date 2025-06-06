<?php

namespace App\Http\Controllers;

use App\Models\Arqueo;
use App\Models\Compra;
use App\Models\detalleCompra;
use App\Models\Empresa;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\TmpCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Nette\Utils\first;
use Barryvdh\DomPDF\Facade\Pdf;

class CompraController extends Controller
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
        $compras = Compra::with('detalles','proveedor')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->get();
        return view('admin.compras.index',compact('compras','arqueoAbierto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::where('empresa_id',Auth::user()->empresa_id)->get();
        $proveedores = Proveedor::where('empresa_id',Auth::user()->empresa_id)->get();

        $session_id = session()->getId();
        $tmp_compras = TmpCompra::where('session_id',$session_id)->get();

        return view('admin.compras.create',compact('productos','proveedores','tmp_compras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha'=>'required',
            'comprobante'=>'required',
            'precio_total'=>'required',
        ]);

        $session_id = session()->getId();

        $compra = new Compra();
        $compra->fecha = $request->fecha;
        $compra->comprobante = $request->comprobante;
        $compra->precio_total = $request->precio_total;
        $compra->proveedor_id = $request->proveedor_id;
        $compra->empresa_id = Auth::user()->empresa_id;
        $compra->save();

        ////REGISTRAR EN EL ARQUEO
        $arqueo_id = Arqueo::whereNull('fecha_cierre')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->first();
        $movimiento = new MovimientoCaja();
        $movimiento->tipo = "EGRESO";
        $movimiento->monto = $request->precio_total;
        $movimiento->descripcion = "Compra de productos";
        $movimiento->arqueo_id = $arqueo_id->id;
        $movimiento->save();
        ////REGISTRAR EN EL ARQUEO

        $tmp_compras = TmpCompra::where('session_id',$session_id)->get();

        foreach ($tmp_compras as $tmp_compra){

            $producto = Producto::where('id',$tmp_compra->producto_id)->first();

            $detalle_compra = new DetalleCompra();
            $detalle_compra->cantidad = $tmp_compra->cantidad;
            $detalle_compra->compra_id = $compra->id;
            $detalle_compra->producto_id = $tmp_compra->producto_id;
            $detalle_compra->save();

            $producto->stock += $tmp_compra->cantidad;
            $producto->save();

        }

        TmpCompra::where('session_id',$session_id)->delete();

        return redirect()->route('admin.compras.index')
            ->with('mensaje','Se registro la compra de la manera correcta')
            ->with('icono','success');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $compra = Compra::with('detalles','proveedor')->findOrFail($id);
        return view('admin.compras.show',compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $compra = Compra::with('detalles','proveedor')->findOrFail($id);

        $proveedores = Proveedor::where('empresa_id',Auth::user()->empresa_id)->get();
        $productos = Producto::where('empresa_id',Auth::user()->empresa_id)->get();

        return view('admin.compras.edit',compact('compra','proveedores','productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //$datos = request()->all();
        //return response()->json($datos);
        $request->validate([
            'fecha'=>'required',
            'comprobante'=>'required',
            'precio_total'=>'required',
        ]);

        $compra = Compra::find($id);
        $compra->fecha = $request->fecha;
        $compra->comprobante = $request->comprobante;
        $compra->precio_total = $request->precio_total;
        $compra->proveedor_id = $request->proveedor_id;
        $compra->empresa_id = Auth::user()->empresa_id;
        $compra->save();

        return redirect()->route('admin.compras.index')
            ->with('mensaje','Se actualizo la compra de la manera correcta')
            ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $compra = Compra::find($id);

        foreach ($compra->detalles as $detalle){
            $producto = Producto::find($detalle->producto_id);
            $producto->stock -= $detalle->cantidad;
            $producto->save();
        }

        $compra->detalles()->delete();

        Compra::destroy($id);

        return redirect()->route('admin.compras.index')
            ->with('mensaje','Se elimino la compra de la manera correcta')
            ->with('icono','success');
    }

    public function reporte(){

        $empresa = Empresa::where('id',Auth::user()->empresa_id)->first();

        $compras = Compra::where('empresa_id',Auth::user()->empresa_id)->get();
        $pdf = PDF::loadView('admin.compras.reporte',compact('compras','empresa'))
            ->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
