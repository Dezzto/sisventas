<?php

namespace App\Http\Controllers;

use App\Models\detalleCompra;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetalleCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $producto = Producto::where('codigo',$request->codigo)
            ->where('empresa_id',Auth::user()->empresa_id)
            ->first();

        $compra_id = $request->id_compra;

        if($producto){

            $detalle_compra_existe = DetalleCompra::where('producto_id',$producto->id)
                ->where('compra_id',$compra_id)
                ->first();

            if($detalle_compra_existe){
                $detalle_compra_existe->cantidad += $request->cantidad;
                $detalle_compra_existe->save();

                $producto->stock -= $request->cantidad;
                $producto->save();

                return response()->json(['success'=>true,'message'=>'El producto fue encontrado']);
            }else{
                $detalle_compra = new DetalleCompra();
                $detalle_compra->cantidad = $request->cantidad;
                $detalle_compra->compra_id = $compra_id;
                $detalle_compra->producto_id = $producto->id;
                $detalle_compra->save();

                $producto->stock -= $request->cantidad;
                $producto->save();

                return response()->json(['success'=>true,'message'=>'El producto fue encontrado']);
            }

        }else{
            return response()->json(['success'=>false,'message'=>'Producto no encontrado']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(detalleCompra $detalleCompra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(detalleCompra $detalleCompra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, detalleCompra $detalleCompra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $detalleCompra = DetalleCompra::find($id);
        $producto = Producto::find($detalleCompra->producto_id);

        $producto->stock += $detalleCompra->cantidad;
        $producto->save();

        DetalleCompra::destroy($id);

        return response()->json(['success'=>true]);
    }
}
