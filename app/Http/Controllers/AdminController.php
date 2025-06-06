<?php

namespace App\Http\Controllers;

use App\Models\Arqueo;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(){

        $empresa_id = Auth::check() ? Auth::user()->empresa_id : redirect()->route('login')->send();

        $total_roles = Role::where('empresa_id',$empresa_id)->count();
        $total_usuarios = User::where('empresa_id',$empresa_id)->count();
        $total_categorias = Categoria::where('empresa_id',$empresa_id)->count();
        $total_productos = Producto::where('empresa_id',$empresa_id)->count();
        $total_proveedores = Proveedor::where('empresa_id',$empresa_id)->count();
        $total_compras = Compra::where('empresa_id',$empresa_id)->count();
        $total_clientes = Cliente::where('empresa_id',$empresa_id)->count();
        $total_arqueos = Arqueo::where('empresa_id',$empresa_id)->count();
        $ventas = Venta::where('empresa_id',$empresa_id)->get();

        $empresa = Empresa::where('id',$empresa_id)->first();
        return view('admin.index',compact(
            'empresa',
                 'total_roles',
                    'total_usuarios',
                    'total_categorias',
                    'total_productos',
                    'total_proveedores',
                    'total_compras',
                    'total_clientes',
                    'total_arqueos',
                    'ventas'));
    }
}
