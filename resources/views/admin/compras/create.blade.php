@extends('adminlte::page')

@section('content_header')
    <h1><b>Compras/Registro de una nueva compra</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ingrese los datos</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/admin/compras/create')}}" id="form_compra" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="cantidad">Cantidad</label><b> *</b>
                                            <input type="number" style="text-align: center;background-color: #ebe7ae" class="form-control" id="cantidad" value="1" name="cantidad" required>
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
                                        <?php $cont = 1; $total_cantidad = 0; $total_compra = 0;?>
                                        @foreach($tmp_compras as $tmp_compra)
                                            <tr>
                                                <td style="text-align: center">{{$cont++}}</td>
                                                <td style="text-align: center">{{$tmp_compra->producto->codigo}}</td>
                                                <td style="text-align: center">{{$tmp_compra->cantidad}}</td>
                                                <td>{{$tmp_compra->producto->nombre}}</td>
                                                <td style="text-align: center">{{$tmp_compra->producto->precio_compra}}</td>
                                                <td style="text-align: center">{{$costo = $tmp_compra->cantidad * $tmp_compra->producto->precio_compra }}</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{$tmp_compra->id}}"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            @php
                                                $total_cantidad += $tmp_compra->cantidad;
                                                $total_compra += $costo;
                                            @endphp
                                        @endforeach
                                        </tbody>
                                        <tfooter>
                                            <tr>
                                                <td colspan="2" style="text-align: right"><b>Total cantidad</b></td>
                                                <td style="text-align: center"><b>{{$total_cantidad}}</b></td>
                                                <td colspan="2" style="text-align: right"><b>Total compra</b></td>
                                                <td style="text-align: center"><b>{{$total_compra}}</b></td>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_proveedor"><i class="fas fa-search"></i> Buscar proveedor</button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal_proveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Listado de proveedores</h5>
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
                                                                <th scope="col">Empresa</th>
                                                                <th scope="col">Teléfono</th>
                                                                <th scope="col">Nombre del proveedor</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php $contador = 1;?>
                                                            @foreach($proveedores as $proveedore)
                                                                <tr>
                                                                    <td style="text-align: center;vertical-align: middle">{{$contador++}}</td>
                                                                    <td style="text-align: center;vertical-align: middle">
                                                                        <button type="button" class="btn btn-info seleccionar-btn-proveedor" data-id="{{$proveedore->id}}" data-empresa="{{$proveedore->empresa}}">Seleccionar</button>
                                                                    </td>
                                                                    <td style="vertical-align: middle">{{$proveedore->empresa}}</td>
                                                                    <td style="vertical-align: middle">{{$proveedore->telefono}}</td>
                                                                    <td style="vertical-align: middle">{{$proveedore->nombre}}</td>
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
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="empresa_proveedor" disabled>
                                        <input type="text" class="form-control" id="id_proveedor" name="proveedor_id" hidden>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha">Fecha de compra</label><b> *</b>
                                            <input type="date" class="form-control" value="{{old('fecha')}}" name="fecha">
                                            @error('fecha')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha">Comprobante</label><b> *</b>
                                            <input type="text" class="form-control" value="{{old('comprobante')}}" name="comprobante">
                                            @error('comprobante')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fecha">Precio total</label><b> *</b>
                                            <input type="text" style="text-align: center;background-color: #e9e710" class="form-control" value="{{$total_compra}}" name="precio_total">
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
                                            <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fas fa-save"></i> Registrar compra</button>
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

        $('.seleccionar-btn-proveedor').click(function () {
            var id_proveedor = $(this).data('id');
            var empresa = $(this).data('empresa');

            $('#empresa_proveedor').val(empresa);
            $('#id_proveedor').val(id_proveedor);
            $('#exampleModal_proveedor').modal('hide');
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
                    url: "{{url('/admin/compras/create/tmp')}}/"+id,
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
        $('#form_compra').on('keypress',function (e) {
            if(e.keyCode === 13){
                e.preventDefault();
            }
        });

        $('#codigo').on('keyup',function (e) {
            if(e.which === 13){
                var codigo = $(this).val();
                var cantidad = $('#cantidad').val();

                if(codigo.length > 0){
                    $.ajax({
                        url: "{{route('admin.compras.tmp_compras')}}",
                        method: 'POST',
                        data: {
                            _token:'{{csrf_token()}}',
                            codigo: codigo,
                            cantidad: cantidad
                        },
                        success:function (response) {
                            if(response.success){
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "El registro el producto",
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
