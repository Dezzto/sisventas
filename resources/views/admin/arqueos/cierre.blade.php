@extends('adminlte::page')

@section('content_header')
    <h1><b>Arqueos/Cierre de arqueo</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ingrese los datos</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/admin/arqueos/create_cierre')}}" method="post">
                        @csrf
                        <input type="text" value="{{$arqueo->id}}" name="id" hidden>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_apertura">Fecha de apertura</label> <b>*</b>
                                    <input type="datetime-local" class="form-control" value="{{$arqueo->fecha_apertura,old('fecha_apertura')}}" name="fecha_apertura" disabled>
                                    @error('fecha_apertura')
                                    <small style="color: red;">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="monto_inicial">Monto inicial</label>
                                    <input type="text" class="form-control" value="{{$arqueo->monto_inicial,old('monto_inicial')}}" name="monto_inicial" disabled>
                                    @error('monto_inicial')
                                    <small style="color: red;">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_cierre">Fecha de cirre</label> <b>*</b>
                                    <input type="datetime-local" class="form-control" value="{{old('fecha_cierre')}}" name="fecha_cierre">
                                    @error('fecha_cierre')
                                    <small style="color: red;">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="monto_final">Monto final</label>
                                    <input type="text" class="form-control" value="{{old('monto_final')}}" name="monto_final">
                                    @error('monto_final')
                                    <small style="color: red;">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{url('/admin/arqueos')}}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
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
@stop
