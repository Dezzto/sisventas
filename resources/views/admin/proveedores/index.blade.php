@extends('adminlte::page')

@section('content_header')
    <h1><b>Proveedores/Listado de proveedores</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Proveedores registrados</h3>
                    <div class="card-tools">
                        <a href="{{url('/admin/proveedores/reporte')}}" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Reporte</a>
                        <a href="{{url('/admin/proveedores/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Crear nuevo</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="mitabla" class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" style="text-align: center">Nro</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nombre del proveedor</th>
                            <th scope="col">Celular</th>
                            <th scope="col" style="text-align: center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $contador = 1;?>
                        @foreach($proveedores as $proveedore)
                            <tr>
                                <td style="text-align: center;vertical-align: middle">{{$contador++}}</td>
                                <td style="vertical-align: middle">{{$proveedore->empresa}}</td>
                                <td style="vertical-align: middle">{{$proveedore->direccion}}</td>
                                <td style="vertical-align: middle">{{$proveedore->telefono}}</td>
                                <td style="vertical-align: middle">{{$proveedore->email}}</td>
                                <td style="text-align: center;vertical-align: middle">{{$proveedore->nombre}}</td>
                                <td style="text-align: center;vertical-align: middle">
                                    <a href="https://wa.me/{{$empresa->codigo_postal."".$proveedore->celular}}"
                                        class="btn btn-success" target="_blank">
                                        {{$empresa->codigo_postal."".$proveedore->celular}}
                                    </a>
                                </td>
                                <td style="text-align: center;vertical-align: middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('/admin/proveedores',$proveedore->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="{{url('/admin/proveedores/'.$proveedore->id.'/edit')}}" class="btn btn-success btn-sm"><i class="fas fa-pencil"></i></a>
                                        <form action="{{url('/admin/proveedores',$proveedore->id)}}" method="post"
                                              onclick="preguntar{{$proveedore->id}}(event)" id="miFormulario{{$proveedore->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 4px 4px 0px"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <script>
                                            function preguntar{{$proveedore->id}}(event) {
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
                                                        var form = $('#miFormulario{{$proveedore->id}}');
                                                        form.submit();
                                                    }
                                                });
                                            }
                                        </script>
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
    <script>
        $('#mitabla').DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Proveedores",
                "infoEmpty": "Mostrando 0 a 0 de 0 Proveedores",
                "infoFiltered": "(Filtrado de _MAX_ total Proveedores)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Proveedores",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
    </script>
@stop
