<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class EmpresaController extends Controller
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
        $paises = DB::table('countries')->get();
        $estados = DB::table('states')->get();
        $ciudades = DB::table('cities')->get();
        $monedas = DB::table('currencies')->get();
        return view('admin.empresas.create',compact('paises','estados','ciudades','monedas'));
    }

    public function buscar_estado($id_pais){
        try{
            $estados = DB::table('states')->where('country_id',$id_pais)->get();
            return view('admin.empresas.cargar_estados',compact('estados'));
        }catch (\Exception $exception){
            return response()->json(['mensaje'=>'Error']);
        }

    }

    public function buscar_ciudad($id_estado){
        try{
            $ciudades = DB::table('cities')->where('state_id',$id_estado)->get();
            return view('admin.empresas.cargar_ciudades',compact('ciudades'));
        }catch (\Exception $exception){
            return response()->json(['mensaje'=>'Error']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$datos = request()->all();
        //return response()->json($datos);

        $request->validate([
            'nombre_empresa'=>'required',
            'tipo_empresa'=>'required',
            'nit'=>'required|unique:empresas',
            'telefono'=>'required',
            'correo'=>'required|unique:empresas',
            'cantidad_impuesto'=>'required',
            'nombre_impuesto'=>'required',
            'direccion'=>'required',
            'logo'=>'required|image|mimes:jpg, jpeg, png',
        ]);

        $empresa = new Empresa();
        $empresa->pais = $request->pais;
        $empresa->nombre_empresa = $request->nombre_empresa;
        $empresa->tipo_empresa = $request->tipo_empresa;
        $empresa->nit = $request->nit;
        $empresa->telefono = $request->telefono;
        $empresa->correo = $request->correo;
        $empresa->cantidad_impuesto = $request->cantidad_impuesto;
        $empresa->nombre_impuesto = $request->nombre_impuesto;
        $empresa->moneda = $request->moneda;
        $empresa->direccion = $request->direccion;
        $empresa->ciudad = $request->ciudad;
        $empresa->departamento = $request->departamento;
        $empresa->codigo_postal = $request->codigo_postal;
        $empresa->logo = $request->file('logo')->store('logos','public');
        $empresa->save();


        $usuario = new User();
        $usuario->name = "Admin";
        $usuario->email = $request->correo;
        $usuario->password = Hash::make($request['nit']);
        $usuario->empresa_id = $empresa->id;
        $usuario->save();


        $rol = new Role();
        $rol->name = "ADMINISTRADOR";
        $rol->empresa_id = $empresa->id;
        $rol->save();

        $usuario->assignRole($rol->id);


        $role = Role::find($rol->id);
        $todos_los_permisos = Permission::pluck('id')->toArray();
        $role->permissions()->sync($todos_los_permisos);

        Auth::login($usuario);

        return redirect()->route('admin.index')
            ->with('mensaje','Se registro la empresa de la manera correcta')
            ->with('icono','success');


    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        $paises = DB::table('countries')->get();
        $estados = DB::table('states')->get();
        //$ciudades = DB::table('cities')->get();
        $monedas = DB::table('currencies')->get();
        $empresa_id = Auth::user()->empresa_id;
        $empresa = Empresa::where('id',$empresa_id)->first();
        $departamentos = DB::table('states')->where('country_id',$empresa->pais)->get();
        $ciudades = DB::table('cities')->where('state_id',$empresa->departamento)->get();
        return view('admin.configuraciones.edit',compact('paises','estados','monedas','empresa','departamentos','ciudades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       // $datos = request()->all();
       // return response()->json($datos);
        $request->validate([
            'nombre_empresa'=>'required',
            'tipo_empresa'=>'required',
            'nit'=>'required|unique:empresas,nit,'.$id,
            'telefono'=>'required',
            'correo'=>'required|unique:empresas,correo,'.$id,
            'cantidad_impuesto'=>'required',
            'nombre_impuesto'=>'required',
            'direccion'=>'required',
        ]);

        $empresa = Empresa::find($id);

        $empresa->pais = $request->pais;
        $empresa->nombre_empresa = $request->nombre_empresa;
        $empresa->tipo_empresa = $request->tipo_empresa;
        $empresa->nit = $request->nit;
        $empresa->telefono = $request->telefono;
        $empresa->correo = $request->correo;
        $empresa->cantidad_impuesto = $request->cantidad_impuesto;
        $empresa->nombre_impuesto = $request->nombre_impuesto;
        $empresa->moneda = $request->moneda;
        $empresa->direccion = $request->direccion;
        $empresa->ciudad = $request->ciudad;
        $empresa->departamento = $request->departamento;
        $empresa->codigo_postal = $request->codigo_postal;

        if($request->hasFile('logo')){
            Storage::delete('public/'.$empresa->logo);
            $empresa->logo = $request->file('logo')->store('logos','public');
        }

        $empresa->save();

        $usuario_id = Auth::user()->id;

        $usuario = User::find($usuario_id);
        $usuario->name = "Admin";
        $usuario->email = $request->correo;
        $usuario->password = Hash::make($request['nit']);
        $usuario->empresa_id = $empresa->id;
        $usuario->save();

        return redirect()->route('admin.index')
            ->with('mensaje','Se modifico los datos de la empresa de la manera correcta')
            ->with('icono','success');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
