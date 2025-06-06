@extends('adminlte::page')

@section('content_header')
    <h1><b>Listado de Arqueos</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Arqueos registrado</h3>
                    <div class="card-tools">
                        <a href="{{url('/admin/arqueos/reporte')}}" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Reporte</a>
                    @if($arqueoAbierto)

                        @else
                            <a href="{{url('/admin/arqueos/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Crear nuevo</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table id="mitabla" class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                        <tr style="text-align: center">
                            <th scope="col" style="text-align: center">Nro</th>
                            <th scope="col">Fecha de apertura</th>
                            <th scope="col">Monto inicial</th>
                            <th scope="col">Fecha de cierre</th>
                            <th scope="col">Monto final</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Movimientos</th>
                            <th scope="col" style="text-align: center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                        $contador = 1;
                        @endphp
                        @foreach($arqueos as $arqueo)
                            <tr>
                                <td style="text-align: center">{{$contador++}}</td>
                                <td style="text-align: center">{{$arqueo->fecha_apertura}}</td>
                                <td style="text-align: center">{{$arqueo->monto_inicial}}</td>
                                <td style="text-align: center">{{$arqueo->fecha_cierre}}</td>
                                <td style="text-align: center">{{$arqueo->monto_final}}</td>
                                <td style="text-align: center">{{$arqueo->descripcion}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Ingresos</b> <br>
                                            {{number_format($arqueo->total_ingresos,2)}}
                                        </div>
                                        <div class="col-md-6">
                                            <b>Egresos</b> <br>
                                            {{number_format($arqueo->total_egresos,2)}}
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align: center;vertical-align: middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('/admin/arqueos',$arqueo->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="{{url('/admin/arqueos/'.$arqueo->id.'/edit')}}" class="btn btn-success btn-sm"><i class="fas fa-pencil"></i></a>
                                        <a href="{{url('/admin/arqueos/'.$arqueo->id.'/ingreso-egreso')}}" class="btn btn-warning btn-sm"><i class="fas fa-cash-register"></i></a>
                                        <a href="{{url('/admin/arqueos/'.$arqueo->id.'/cierre')}}" class="btn btn-secondary btn-sm"><i class="fas fa-lock"></i></a>
                                        <form action="{{url('/admin/arqueos',$arqueo->id)}}" method="post"
                                              onclick="preguntar{{$arqueo->id}}(event)" id="miFormulario{{$arqueo->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 4px 4px 0px"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <script>
                                            function preguntar{{$arqueo->id}}(event) {
                                                event.preventDefault();
                                                Swal.fire({
                                                    title: '¿Desea eliminar esta registro?',
                                                    text: 'Si eliminas este arqueo, se borrara todos los movimientos que perteneces al arqueo',
                                                    icon: 'question',
                                                    showDenyButton: true,
                                                    confirmButtonText: 'Eliminar',
                                                    confirmButtonColor: '#a5161d',
                                                    denyButtonColor: '#270a0a',
                                                    denyButtonText: 'Cancelar',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        var form = $('#miFormulario{{$arqueo->id}}');
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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Arqueos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Arqueos",
                "infoFiltered": "(Filtrado de _MAX_ total Arqueos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Arqueos",
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
