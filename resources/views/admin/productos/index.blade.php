@extends('adminlte::page')

@section('content_header')
    <h1><b>Productos/Listado de productos</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Productos registrados</h3>
                    <div class="card-tools">
                        <a href="{{url('/admin/productos/reporte')}}" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Reporte</a>
                        <a href="{{url('/admin/productos/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Crear nuevo</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="mitabla" class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" style="text-align: center">Nro</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Código</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Precio compra</th>
                            <th scope="col">Precio venta</th>
                            <th scope="col">Imagen</th>
                            <th scope="col" style="text-align: center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $contador = 1;?>
                        @foreach($productos as $producto)
                            <tr>
                                <td style="text-align: center;vertical-align: middle">{{$contador++}}</td>
                                <td style="vertical-align: middle">{{$producto->categoria->nombre}}</td>
                                <td style="vertical-align: middle">{{$producto->codigo}}</td>
                                <td style="vertical-align: middle">{{$producto->nombre}}</td>
                                <td style="vertical-align: middle">{{$producto->descripcion}}</td>
                                <td style="text-align: center;vertical-align: middle;background-color: rgba(233,231,16,0.15)">{{$producto->stock}}</td>
                                <td style="text-align: center;vertical-align: middle">{{$producto->precio_compra}}</td>
                                <td style="text-align: center;vertical-align: middle">{{$producto->precio_venta}}</td>
                                <td style="text-align: center">
                                    <img src="{{asset('storage/'.$producto->imagen)}}" width="80px" alt="imagen">
                                </td>
                                <td style="text-align: center;vertical-align: middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('/admin/productos',$producto->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="{{url('/admin/productos/'.$producto->id.'/edit')}}" class="btn btn-success btn-sm"><i class="fas fa-pencil"></i></a>
                                        <form action="{{url('/admin/productos',$producto->id)}}" method="post"
                                              onclick="preguntar{{$producto->id}}(event)" id="miFormulario{{$producto->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 4px 4px 0px"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <script>
                                            function preguntar{{$producto->id}}(event) {
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
                                                        var form = $('#miFormulario{{$producto->id}}');
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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
                "infoFiltered": "(Filtrado de _MAX_ total Productos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Productos",
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
