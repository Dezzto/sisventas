@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><b>Listado de Roles</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Roles registrado</h3>
                    <div class="card-tools">
                        <a href="{{url('/admin/roles/reporte')}}" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Reporte</a>
                        <a href="{{url('/admin/roles/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Crear nuevo</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" style="text-align: center">Nro</th>
                            <th scope="col">Nombre del rol</th>
                            <th scope="col" style="text-align: center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $contador = 1;?>
                        @foreach($roles as $role)
                            <tr>
                                <td style="text-align: center">{{$contador++}}</td>
                                <td>{{$role->name}}</td>
                                <td style="text-align: center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('/admin/roles',$role->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        @if($role->name !== 'ADMINISTRADOR')
                                            <a href="{{url('/admin/roles/'.$role->id.'/edit')}}" class="btn btn-success btn-sm"><i class="fas fa-pencil"></i></a>
                                        @endif
                                        <a href="{{url('/admin/roles/'.$role->id.'/asignar')}}" class="btn btn-warning btn-sm"><i class="fas fa-check"></i></a>
                                        @if($role->name !== 'ADMINISTRADOR')
                                        <form action="{{url('/admin/roles',$role->id)}}" method="post"
                                              onclick="preguntar{{$role->id}}(event)" id="miFormulario{{$role->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 4px 4px 0px"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <script>
                                            function preguntar{{$role->id}}(event) {
                                                event.preventDefault();
                                                Swal.fire({
                                                    title: '¿Desea eliminar esta registro?',
                                                    text: '',
                                                    icon: 'question',
                                                    showDenyButton: true,
                                                    confirmButtonText: 'Eliminar',
                                                    confirmButtonColor: '#a5161d',
                                                    denyButtonColor: '#270a0a',
                                                    denyButtonText: 'Cancelar',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        var form = $('#miFormulario{{$role->id}}');
                                                        form.submit();
                                                    }
                                                });
                                            }
                                        </script>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
