<?php

namespace App\Http\Controllers;

use App\Models\Arqueo;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Empresa;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\TmpVenta;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Nnjeim\World\Models\Currency;
use NumberToWords\NumberToWords;
use NumberFormatter;

class VentaController extends Controller
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
        $ventas = Venta::with('detallesVenta','cliente')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->get();
        return view('admin.ventas.index',compact('ventas','arqueoAbierto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::where('empresa_id',Auth::user()->empresa_id)->get();
        $clientes = Cliente::where('empresa_id',Auth::user()->empresa_id)->get();

        $session_id = session()->getId();
        $tmp_ventas = TmpVenta::where('session_id',$session_id)->get();

        return view('admin.ventas.create',compact('productos','clientes','tmp_ventas'));
    }

    public function cliente_store(Request $request){
        $validate = $request->validate([
            'nombre_cliente' => 'required',
            'nit_codigo' => 'required',
            'telefono' => 'required',
            'email' => 'required',
        ]);

        $cliente = new Cliente();
        $cliente->nombre_cliente = $request->nombre_cliente;
        $cliente->nit_codigo = $request->nit_codigo;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;
        $cliente->empresa_id = Auth::user()->empresa_id;
        $cliente->save();

        return response()->json(['success'=>'Cliente registrado']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$datos = request()->all();
        //return response()->json($datos);
        $request->validate([
            'fecha'=>'required',
            'precio_total'=>'required',
        ]);

        $session_id = session()->getId();

        $venta = new Venta();
        $venta->fecha = $request->fecha;
        $venta->precio_total = $request->precio_total;
        $venta->empresa_id = Auth::user()->empresa_id;
        $venta->cliente_id = $request->cliente_id;
        $venta->save();

        ////REGISTRAR EN EL ARQUEO
        $arqueo_id = Arqueo::whereNull('fecha_cierre')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->first();
        $movimiento = new MovimientoCaja();
        $movimiento->tipo = "INGRESO";
        $movimiento->monto = $request->precio_total;
        $movimiento->descripcion = "Venta de productos";
        $movimiento->arqueo_id = $arqueo_id->id;
        $movimiento->save();
        ////REGISTRAR EN EL ARQUEO

        $tmp_ventas = TmpVenta::where('session_id',$session_id)->get();

        foreach ($tmp_ventas as $tmp_venta){

            $producto = Producto::where('id',$tmp_venta->producto_id)->first();

            $detalle_venta = new DetalleVenta();
            $detalle_venta->cantidad = $tmp_venta->cantidad;
            $detalle_venta->venta_id = $venta->id;
            $detalle_venta->producto_id = $tmp_venta->producto_id;
            $detalle_venta->save();

            $producto->stock -= $tmp_venta->cantidad;
            $producto->save();

        }

        TmpVenta::where('session_id',$session_id)->delete();

        return redirect()->route('admin.ventas.index')
            ->with('mensaje','Se registro la venta de la manera correcta')
            ->with('icono','success');
    }

    public function pdf($id){

        function numeroALetrasConDecimales($numero)
        {
            $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);

            // Dividir el número en parte entera y decimal
            $partes = explode('.', number_format($numero, 2, '.', ''));

            $entero = $formatter->format($partes[0]);
            $decimal = $formatter->format($partes[1]);

            return ucfirst("$entero con $decimal/100");
        }

        $id_empresa = Auth::user()->empresa_id;
        $empresa = Empresa::where('id',$id_empresa)->first();
        $moneda = Currency::find($empresa->moneda);
        $venta = Venta::with('detallesVenta','cliente')->findOrFail($id);

        $numero = $venta->precio_total;
        $literal = numeroALetrasConDecimales($numero);

        $pdf = PDF::loadView('admin.ventas.pdf',compact('empresa','venta','moneda','literal'));
        return $pdf->stream();
        //return view('admin.ventas.pdf');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $venta = Venta::with('detallesVenta','cliente')->findOrFail($id);
        return view('admin.ventas.show',compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $productos = Producto::where('empresa_id',Auth::user()->empresa_id)->get();
        $clientes = Cliente::where('empresa_id',Auth::user()->empresa_id)->get();
        $venta = Venta::with('detallesVenta','cliente')->findOrFail($id);
        return view('admin.ventas.edit',compact('venta','productos','clientes'));
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
            'precio_total'=>'required',
        ]);

        $venta = Venta::find($id);
        $venta->fecha = $request->fecha;
        $venta->precio_total = $request->precio_total;
        $venta->cliente_id = $request->cliente_id;
        $venta->empresa_id = Auth::user()->empresa_id;
        $venta->save();

        return redirect()->route('admin.ventas.index')
            ->with('mensaje','Se actualizo la ventas de la manera correcta')
            ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $venta = Venta::find($id);

        foreach ($venta->detallesVenta as $detalle){
            $producto = Producto::find($detalle->producto_id);
            $producto->stock += $detalle->cantidad;
            $producto->save();
        }

        $venta->detallesVenta()->delete();

        Venta::destroy($id);

        return redirect()->route('admin.ventas.index')
            ->with('mensaje','Se elimino la venta de la manera correcta')
            ->with('icono','success');
    }

    public function reporte(){

        $empresa = Empresa::where('id',Auth::user()->empresa_id)->first();

        $ventas = Venta::with('cliente')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->get();
        $pdf = PDF::loadView('admin.ventas.reporte',compact('ventas','empresa'));
        return $pdf->stream();
    }
}
