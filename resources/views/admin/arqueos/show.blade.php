@extends('adminlte::page')

@section('content_header')
    <h1><b>Arqueos/Detalles del arqueo</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Datos registrados</h3>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_apertura">Fecha de apertura</label>
                                    <input type="datetime-local" class="form-control" value="{{$arqueo->fecha_apertura,old('fecha_apertura')}}" name="fecha_apertura" disabled>
                                    @error('fecha_apertura')
                                    <small style="color: red;">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="monto_inicial">Monto Inicial</label>
                                    <input type="text" class="form-control" value="{{$arqueo->monto_inicial,old('monto_inicial')}}" name="monto_inicial" disabled>
                                    @error('monto_inicial')
                                    <small style="color: red;">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_apertura">Fecha de cierre</label>
                                    <input type="datetime-local" class="form-control" value="{{$arqueo->fecha_cierre}}"  disabled>
                                    @error('fecha_apertura')
                                    <small style="color: red;">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="monto_inicial">Monto Inicial</label>
                                    <input type="text" class="form-control" value="{{$arqueo->monto_final}}" name="monto_inicial" disabled>
                                    @error('monto_inicial')
                                    <small style="color: red;">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" class="form-control" value="{{$arqueo->descripcion ,old('descripcion')}}" name="descripcion" disabled>
                                    @error('descripcion')
                                    <small style="color: red;">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{url('/admin/arqueos')}}" class="btn btn-secondary">Volver</a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ingresos</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm table-striped table-hover">
                        <thead>
                            <tr style="text-align: center">
                                <th>Nro</th>
                                <th>Detalle</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $contador = 1;
                        $suma_monto = 0;
                        ?>
                        @foreach($movimientos as $movimiento)
                            @if($movimiento->tipo == "INGRESO")
                                @php
                                $suma_monto += $movimiento->monto;
                                @endphp
                                <tr>
                                    <td style="text-align: center">{{$contador++}}</td>
                                    <td>{{$movimiento->descripcion}}</td>
                                    <td style="text-align: center">{{$movimiento->monto}}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfooter>
                            <tr>
                                <td colspan="2" style="text-align: center"><b>Total</b></td>
                                <td style="text-align: center"><b>{{$suma_monto}}</b></td>
                            </tr>
                        </tfooter>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Egresos</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm table-striped table-hover">
                        <thead>
                        <tr style="text-align: center">
                            <th>Nro</th>
                            <th>Detalle</th>
                            <th>Monto</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $contador = 1;
                        $suma_monto = 0;
                        ?>
                        @foreach($movimientos as $movimiento)
                            @if($movimiento->tipo == "EGRESO")
                                @php
                                    $suma_monto += $movimiento->monto;
                                @endphp
                                <tr>
                                    <td style="text-align: center">{{$contador++}}</td>
                                    <td>{{$movimiento->descripcion}}</td>
                                    <td style="text-align: center">{{$movimiento->monto}}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfooter>
                            <tr>
                                <td colspan="2" style="text-align: center"><b>Total</b></td>
                                <td style="text-align: center"><b>{{$suma_monto}}</b></td>
                            </tr>
                        </tfooter>
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
