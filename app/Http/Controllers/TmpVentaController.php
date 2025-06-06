<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\TmpVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TmpVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function tmp_ventas(Request $request){

        $producto = Producto::where('codigo',$request->codigo)
            ->where('empresa_id',Auth::user()->empresa_id)
            ->first();

        $session_id = session()->getId();

        if($producto){

            if($request->cantidad > $producto->stock){
                return response()->json([
                    'success' => false,
                    'message' => 'La cantidad solicitada excede el stock disponible. Solo quedan '.$producto->stock.' unidad'
                ]);
            }

            $tmp_venta_existe = TmpVenta::where('producto_id',$producto->id)
                ->where('session_id',$session_id)
                ->first();

            if($tmp_venta_existe){
                $tmp_venta_existe->cantidad += $request->cantidad;
                $tmp_venta_existe->save();
                return response()->json(['success'=>true,'message'=>'El producto fue encontrado']);
            }else{
                $tmp_venta = new TmpVenta();
                $tmp_venta->cantidad = $request->cantidad;
                $tmp_venta->producto_id = $producto->id;
                $tmp_venta->session_id = $session_id;
                $tmp_venta->save();
                return response()->json(['success'=>true,'message'=>'El producto fue encontrado']);
            }

        }else{
            return response()->json(['success'=>false,'message'=>'Producto no encontrado']);
        }
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        TmpVenta::destroy($id);
        return response()->json(['success'=>true]);
    }
}
