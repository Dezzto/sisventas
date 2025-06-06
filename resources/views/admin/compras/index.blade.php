@extends('adminlte::page')

@section('content_header')
    <h1><b>Compras/Listado de compras</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Compras registradas</h3>
                    <div class="card-tools">
                        <a href="{{url('/admin/compras/reporte')}}" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Reporte</a>
                    @if($arqueoAbierto)
                            <a href="{{url('/admin/compras/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Crear nuevo</a>
                        @else
                            <a href="{{url('/admin/arqueos/create')}}" class="btn btn-danger"><i class="fa fa-plus"></i> Abrir caja</a>
                        @endif

                    </div>
                </div>
                <div class="card-body">
                    <table id="mitabla" class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" style="text-align: center">Nro</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Comprobante</th>
                            <th scope="col">Precio total</th>
                            <th scope="col">Productos</th>
                            <th scope="col" style="text-align: center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $contador = 1;?>
                        @foreach($compras as $compra)
                            <tr>
                                <td style="text-align: center;vertical-align: middle">{{$contador++}}</td>
                                <td style="vertical-align: middle">{{$compra->fecha}}</td>
                                <td style="vertical-align: middle">{{$compra->comprobante}}</td>
                                <td style="vertical-align: middle">{{$compra->precio_total}}</td>
                                <td style="vertical-align: middle">
                                    <ul>
                                        @foreach($compra->detalles as $detalle)
                                            <li>{{$detalle->producto->nombre.' - '.$detalle->cantidad.' Unidades'}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td style="text-align: center;vertical-align: middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('/admin/compras',$compra->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="{{url('/admin/compras/'.$compra->id.'/edit')}}" class="btn btn-success btn-sm"><i class="fas fa-pencil"></i></a>
                                        <form action="{{url('/admin/compras',$compra->id)}}" method="post"
                                              onclick="preguntar{{$compra->id}}(event)" id="miFormulario{{$compra->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 4px 4px 0px"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <script>
                                            function preguntar{{$compra->id}}(event) {
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
                                                        var form = $('#miFormulario{{$compra->id}}');
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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Compras",
                "infoEmpty": "Mostrando 0 a 0 de 0 Compras",
                "infoFiltered": "(Filtrado de _MAX_ total Compras)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Compras",
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
