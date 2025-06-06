@extends('adminlte::page')

@section('content_header')
    <h1><b>Compras/Detalle de la compra</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Datos registrados</h3>
                </div>
                <div class="card-body">

                        <div class="row">
                            <div class="col-md-8">
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
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $cont = 1; $total_cantidad = 0; $total_compra = 0;?>
                                        @foreach($compra->detalles as $detalle)
                                            <tr>
                                                <td style="text-align: center">{{$cont++}}</td>
                                                <td style="text-align: center">{{$detalle->producto->codigo}}</td>
                                                <td style="text-align: center">{{$detalle->cantidad}}</td>
                                                <td>{{$detalle->producto->nombre}}</td>
                                                <td style="text-align: center">{{$detalle->producto->precio_compra}}</td>
                                                <td style="text-align: center">{{$costo = $detalle->cantidad * $detalle->producto->precio_compra }}</td>
                                            </tr>
                                            @php
                                                $total_cantidad += $detalle->cantidad;
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
                                    <div class="col-md-12">
                                        <label for="">Proveedor</label>
                                        <input type="text" class="form-control" value="{{$compra->proveedor->empresa}}" id="id_proveedor" name="proveedor_id" disabled="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha">Fecha de compra</label>
                                            <input type="date" class="form-control" value="{{$compra->fecha}}" name="fecha" disabled>
                                            @error('fecha')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha">Comprobante</label>
                                            <input type="text" class="form-control" value="{{$compra->comprobante}}" name="comprobante" disabled>
                                            @error('comprobante')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fecha">Precio total</label>
                                            <input type="text" style="text-align: center;background-color: #e9e710" class="form-control" value="{{$total_compra}}" name="precio_total" disabled>
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
                                            <a href="{{url('/admin/compras')}}" type="submit" class="btn btn-secondary btn-lg btn-block"> Volver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
