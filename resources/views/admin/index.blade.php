@extends('adminlte::page')

@section('content_header')
    <h1><b>Bienvenido {{$empresa->nombre_empresa}}</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box zoomP">
                <a href="{{url('/admin/roles')}}" class="info-box-icon bg-info">
                    <span class=""><i class="fas fa-user-check"></i></span>
                </a>
                <div class="info-box-content">
                    <span class="info-box-text">Roles registrado</span>
                    <span class="info-box-number">{{$total_roles}} roles</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box zoomP">
                <a href="{{url('/admin/usuarios')}}" class="info-box-icon bg-primary">
                    <span class=""><i class="fas fa-users"></i></span>
                </a>
                <div class="info-box-content">
                    <span class="info-box-text">Usuarios registrado</span>
                    <span class="info-box-number">{{$total_usuarios}} usuarios</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box zoomP">
                <a href="{{url('/admin/categorias')}}" class="info-box-icon bg-success">
                    <span class=""><i class="fas fa-tags"></i></span>
                </a>
                <div class="info-box-content">
                    <span class="info-box-text">Categorías registrado</span>
                    <span class="info-box-number">{{$total_categorias}} categorías</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box zoomP">
                <a href="{{url('/admin/productos')}}" class="info-box-icon bg-warning">
                    <span class=""><i class="fas fa-list"></i></span>
                </a>
                <div class="info-box-content">
                    <span class="info-box-text">Productos registrado</span>
                    <span class="info-box-number">{{$total_productos}} productos</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box zoomP">
                <a href="{{url('/admin/proveedores')}}" class="info-box-icon bg-danger">
                    <span class=""><i class="fas fa-list"></i></span>
                </a>
                <div class="info-box-content">
                    <span class="info-box-text">Proveedores registrado</span>
                    <span class="info-box-number">{{$total_proveedores}} proveedores</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box zoomP">
                <a href="{{url('/admin/compras')}}" class="info-box-icon bg-dark">
                    <span class=""><i class="fas fa-shopping-cart"></i></span>
                </a>
                <div class="info-box-content">
                    <span class="info-box-text">Compras registrado</span>
                    <span class="info-box-number">{{$total_compras}} compras</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box zoomP">
                <a href="{{url('/admin/clientes')}}" class="info-box-icon bg-info">
                    <span class=""><i class="fas fa-users"></i></span>
                </a>
                <div class="info-box-content">
                    <span class="info-box-text">Clientes registrado</span>
                    <span class="info-box-number">{{$total_clientes}} clientes</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box zoomP">
                <a href="{{url('/admin/arqueos')}}" class="info-box-icon bg-primary">
                    <span class=""><i class="fas fa-cash-register"></i></span>
                </a>
                <div class="info-box-content">
                    <span class="info-box-text">Arqueos registrado</span>
                    <span class="info-box-number">{{$total_arqueos}} arqueos</span>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Total cantidad de ventas</h3>
                </div>
                <div class="card-body">
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Total costo de ventas</h3>
                </div>
                <div class="card-body">
                    <div>
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <?php
    $meses = array_fill(1,12,0);
    $suma_ventas = array_fill(1,12,0);
    foreach ($ventas as $venta){
        $fecha = strtotime($venta['fecha']);
        $mes = date('m',$fecha);

        $meses[(int)$mes]++;
        $suma_ventas[(int)$mes] += $venta['precio_total'];
    }

    $reporte_cantidad = implode(',',$meses);
    $reporte_ventas = implode(',',$suma_ventas);
    ?>
    <script>
        var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio',
            'Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        var datos =[{{$reporte_cantidad}}];
        const ctx2 = document.getElementById('myChart');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Cantidad de ventas',
                    data: datos,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio',
            'Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        var datos =[{{$reporte_ventas}}];
        const ctx = document.getElementById('myChart2');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Monto Total de ventas',
                    data: datos,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@stop
