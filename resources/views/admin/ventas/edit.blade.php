@extends('adminlte::page')

@section('content_header')
    <h1><b>Ventas/Modificación de la venta</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Ingrese los datos</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/admin/ventas',$venta->id)}}" id="form_venta" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="cantidad">Cantidad</label><b> *</b>
                                            <input type="number" style="text-align: center;background-color: #ebe7ae" class="form-control" id="cantidad" value="1" required>
                                            @error('cantidad')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Codigo</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                            </div>
                                            <input id="codigo" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div style="height: 32px"></div>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Listado de productos</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table id="mitabla" class="table table-striped table-bordered table-hover table-sm table-responsive">
                                                                <thead class="thead-light">
                                                                <tr>
                                                                    <th scope="col" style="text-align: center">Nro</th>
                                                                    <th scope="col" style="text-align: center">Acción</th>
                                                                    <th scope="col">Categoría</th>
                                                                    <th scope="col">Código</th>
                                                                    <th scope="col">Nombre</th>
                                                                    <th scope="col">Descripción</th>
                                                                    <th scope="col">Stock</th>
                                                                    <th scope="col">Precio compra</th>
                                                                    <th scope="col">Precio venta</th>
                                                                    <th scope="col">Imagen</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php $contador = 1;?>
                                                                @foreach($productos as $producto)
                                                                    <tr>
                                                                        <td style="text-align: center;vertical-align: middle">{{$contador++}}</td>
                                                                        <td style="text-align: center;vertical-align: middle">
                                                                            <button type="button" class="btn btn-info seleccionar-btn" data-id="{{$producto->codigo}}">Seleccionar</button>
                                                                        </td>
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
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{url('/admin/productos/create')}}" type="button" class="btn btn-success"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-sm table-striped table-bordered table-hover">
                                        <thead>
                                        <tr style="background-color: #cccccc">
                                            <th>Nro</th>
                                            <th>Codígo</th>
                                            <th>Cantidad</th>
                                            <th>Nombre</th>
                                            <th>Costo</th>
                                            <th>Total</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $cont = 1; $total_cantidad = 0; $total_venta = 0;?>
                                        @foreach($venta->detallesVenta as $detalle)
                                            <tr>
                                                <td style="text-align: center">{{$cont++}}</td>
                                                <td style="text-align: center">{{$detalle->producto->codigo}}</td>
                                                <td style="text-align: center">{{$detalle->cantidad}}</td>
                                                <td>{{$detalle->producto->nombre}}</td>
                                                <td style="text-align: center">{{$detalle->producto->precio_venta}}</td>
                                                <td style="text-align: center">{{$costo = $detalle->cantidad * $detalle->producto->precio_venta }}</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{$detalle->id}}"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            @php
                                                $total_cantidad += $detalle->cantidad;
                                                $total_venta += $costo;
                                            @endphp
                                        @endforeach
                                        </tbody>
                                        <tfooter>
                                            <tr>
                                                <td colspan="2" style="text-align: right"><b>Total cantidad</b></td>
                                                <td style="text-align: center"><b>{{$total_cantidad}}</b></td>
                                                <td colspan="2" style="text-align: right"><b>Total venta</b></td>
                                                <td style="text-align: center"><b>{{$total_venta}}</b></td>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_cliente"><i class="fas fa-search"></i> Buscar cliente</button>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal_crear_cliente"><i class="fas fa-plus"></i></button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal_cliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Listado de clientes</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table id="mitabla2" class="table table-striped table-bordered table-hover table-sm table-responsive">
                                                            <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col" style="text-align: center">Nro</th>
                                                                <th scope="col" style="text-align: center">Acción</th>
                                                                <th scope="col">Nombre del cliente</th>
                                                                <th scope="col">Nit/Código</th>
                                                                <th scope="col">Teléfono</th>
                                                                <th scope="col">Email</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php $contador = 1;?>
                                                            @foreach($clientes as $cliente)
                                                                <tr>
                                                                    <td style="text-align: center;vertical-align: middle">{{$contador++}}</td>
                                                                    <td style="text-align: center;vertical-align: middle">
                                                                        <button type="button" class="btn btn-info seleccionar-btn-cliente" data-id="{{$cliente->id}}" data-nit="{{$cliente->nit_codigo}}" data-nombrecliente="{{$cliente->nombre_cliente}}">Seleccionar</button>
                                                                    </td>
                                                                    <td style="vertical-align: middle">{{$cliente->nombre_cliente}}</td>
                                                                    <td style="vertical-align: middle">{{$cliente->nit_codigo}}</td>
                                                                    <td style="vertical-align: middle">{{$cliente->telefono}}</td>
                                                                    <td style="vertical-align: middle">{{$cliente->email}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="exampleModal_crear_cliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo cliente</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="name">Nombre del cliente</label>
                                                                    <input type="text" class="form-control" value="{{old('nombre_cliente')}}" id="nombre_cliente">
                                                                    @error('nombre_cliente')
                                                                    <small style="color: red;">{{$message}}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="name">Nit/código del cliente</label>
                                                                    <input type="text" class="form-control" value="{{old('nit_codigo')}}" id="nit_codigo">
                                                                    @error('nit_codigo')
                                                                    <small style="color: red;">{{$message}}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="name">Teléfono</label>
                                                                    <input type="text" class="form-control" value="{{old('telefono')}}" id="telefono">
                                                                    @error('telefono')
                                                                    <small style="color: red;">{{$message}}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="name">Email</label>
                                                                    <input type="email" class="form-control" value="{{old('email')}}" id="email">
                                                                    @error('email')
                                                                    <small style="color: red;">{{$message}}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button type="button" onclick="guardar_cliente()" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Nombre del cliente</label>
                                        <input type="text" class="form-control" id="nombre_cliente_select" value="{{$venta->cliente->nombre_cliente ?? 'S/N'}}">
                                        <input type="text" class="form-control" id="id_cliente" name="cliente_id" value="{{$venta->cliente->id ?? ''}}" hidden>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">NIT/Código</label>
                                        <input type="text" class="form-control" id="nit_cliente_select" value="{{$venta->cliente->nit_codigo ?? '0' }}">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fecha">Fecha de venta</label><b> *</b>
                                            <input type="date" class="form-control" value="{{old('fecha', $venta->fecha)}}" name="fecha">
                                            @error('fecha')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fecha">Precio total</label><b> *</b>
                                            <input type="text" style="text-align: center;background-color: #e9e710" class="form-control" value="{{$total_venta}}" name="precio_total">
                                            @error('precio_total')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fas fa-save"></i> Actualizar venta</button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>

        function guardar_cliente(){
            const data = {
                nombre_cliente: $('#nombre_cliente').val(),
                nit_codigo: $('#nit_codigo').val(),
                telefono: $('#telefono').val(),
                email: $('#email').val(),
                _token: '{{csrf_token()}}'
            };

            $.ajax({
                url: '{{route("admin.ventas.cliente.store")}}',
                type: 'POST',
                data: data,
                success:function (response) {
                    if(response.success){
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Se agrego al cliente",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload();
                    }else{
                        alert('Error no se pudo eliminar el producto');
                    }
                },
                error: function (xhr, status, error) {
                    alert('error, no se pudo registrar al cliente');
                }
            });
        }

        $('.seleccionar-btn-cliente').click(function () {
            var id_cliente = $(this).data('id');
            var nombre_cliente = $(this).data('nombrecliente');
            var nit_codigo = $(this).data('nit');
            //alert(nombre_cliente);
            $('#nombre_cliente_select').val(nombre_cliente);
            $('#nit_cliente_select').val(nit_codigo);
            $('#id_cliente').val(id_cliente);
            $('#exampleModal_cliente').modal('hide');
        });

        $('.seleccionar-btn').click(function () {
            var id_producto = $(this).data('id');
            $('#codigo').val(id_producto);
            $('#exampleModal').modal('hide');
            $('#exampleModal').on('hidden.bs.modal', function () {
                $('#codigo').focus();
            });
        });

        $('.delete-btn').click(function () {
            var id = $(this).data('id');
            if(id){
                $.ajax({
                    url: "{{url('/admin/ventas/detalle')}}/"+id,
                    type: 'POST',
                    data: {
                        _token:'{{csrf_token()}}',
                        _method:'DELETE'
                    },
                    success:function (response) {
                        if(response.success){
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Se elimino el producto",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            location.reload();
                        }else{
                            alert('Error no se pudo eliminar el producto');
                        }
                    },
                    error:function (error) {
                        alert(error);
                    }
                });
            }
        });

        $('#codigo').focus();
        $('#form_venta').on('keypress',function (e) {
            if(e.keyCode === 13){
                e.preventDefault();
            }
        });

        $('#codigo').on('keyup',function (e) {
            if(e.which === 13){
                var codigo = $(this).val();
                var cantidad = $('#cantidad').val();
                var id_venta = '{{$venta->id}}';

                if(codigo.length > 0){
                    $.ajax({
                        url: "{{route('admin.detalle.ventas.store')}}",
                        method: 'POST',
                        data: {
                            _token:'{{csrf_token()}}',
                            codigo: codigo,
                            cantidad: cantidad,
                            id_venta: id_venta
                        },
                        success:function (response) {
                            if(response.success){
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Se registro el producto",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            }else{
                                alert('no se encontro al producto');
                            }
                        },
                        error:function (error) {
                            alert(error);
                        }
                    });
                }
            }
        });
    </script>
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

        $('#mitabla2').DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Clientes",
                "infoFiltered": "(Filtrado de _MAX_ total Clientes)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Clientes",
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
