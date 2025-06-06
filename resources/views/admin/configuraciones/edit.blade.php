@extends('adminlte::page')

@section('content_header')
    <h1>Configuraciones/Editar</h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{-- Card Box --}}
            <div class="card card-outline card-success"
                 style="box-shadow: 5px 5px 5px 5px #cccccc" class="">

                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                    <h3 class="card-title float-none">
                        <b>Datos registrados</b>
                    </h3>
                </div>


                {{-- Card Body --}}
                <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                    <form action="{{url('/admin/configuracion',$empresa->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" id="file" name="logo" accept=".jpg, .jpeg, .png" class="form-control">
                                    @error('logo')
                                    <small style="color: red;">{{$message}}</small>
                                    @enderror
                                    <br>
                                    <center>
                                        <output id="list">
                                            <img src="{{asset('storage/'.$empresa->logo)}}" width="80%" alt="logo">
                                        </output>
                                    </center>
                                    <script>
                                        function archivo(evt) {
                                            var files = evt.target.files; // FileList object
                                            // Obtenemos la imagen del campo "file".
                                            for (var i = 0, f; f = files[i]; i++) {
                                                //Solo admitimos imágenes.
                                                if (!f.type.match('image.*')) {
                                                    continue;
                                                }
                                                var reader = new FileReader();
                                                reader.onload = (function (theFile) {
                                                    return function (e) {
                                                        // Insertamos la imagen
                                                        document.getElementById("list").innerHTML = ['<img class="thumb thumbnail" src="',e.target.result, '" width="70%" title="', escape(theFile.name), '"/>'].join('');
                                                    };
                                                })(f);
                                                reader.readAsDataURL(f);
                                            }
                                        }
                                        document.getElementById('file').addEventListener('change', archivo, false);
                                    </script>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pais">País</label>
                                            <select name="pais" id="select_pais" class="form-control">
                                                @foreach($paises as $paise)
                                                    <option value="{{$paise->id}}" {{$empresa->pais == $paise->id ? 'selected':''}}>{{$paise->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="departamento">Estado/Provincia/Región</label>
                                            <select name="departamento" id="select_departamento_2" class="form-control">
                                                @foreach($departamentos as $departamento)
                                                    <option value="{{$departamento->id}}" {{$empresa->departamento == $departamento->id ? 'selected':''}}>{{$departamento->name}}</option>
                                                @endforeach
                                            </select>
                                            <div id="respuesta_pais">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="ciudad">Ciudad</label>
                                            <select name="ciudad" id="select_ciudad_2" class="form-control">
                                                @foreach($ciudades as $ciudade)
                                                    <option value="{{$ciudade->id}}" {{$empresa->ciudad == $ciudade->id ? 'selected':''}}>{{$ciudade->name}}</option>
                                                @endforeach
                                            </select>
                                            <div id="respuesta_estado">

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nombre_empresa">Nombre de la Empresa</label>
                                            <input type="text" value="{{$empresa->nombre_empresa}}" name="nombre_empresa" class="form-control" required>
                                            @error('nombre_empresa')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipo_empresa">Tipo de la Empresa</label>
                                            <input type="text" value="{{$empresa->tipo_empresa}}" name="tipo_empresa" class="form-control" required>
                                            @error('tipo_empresa')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nit">NIT</label>
                                            <input type="text" name="nit" value="{{$empresa->nit}}" class="form-control" required>
                                            @error('nit')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="moneda">Modena</label>
                                            <select name="moneda" id="" class="form-control">
                                                @foreach($monedas as $moneda)
                                                    <option value="{{$moneda->id}}" {{$empresa->moneda == $moneda->id ? 'selected':''}}>{{$moneda->symbol}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nombre_impuesto">Nombre del impuesto</label>
                                            <input type="text" name="nombre_impuesto" value="{{$empresa->nombre_impuesto}}" class="form-control" required>
                                            @error('nombre_impuesto')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="cantidad_impuesto">Cantidad</label>
                                            <input type="number" value="{{$empresa->cantidad_impuesto}}" name="cantidad_impuesto" class="form-control" required>
                                            @error('cantidad_impuesto')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="telefono">Teléfonos de la Empresa</label>
                                            <input type="text" name="telefono" value="{{$empresa->telefono}}" class="form-control" required>
                                            @error('telefono')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="correo">Correo de la Empresa</label>
                                            <input type="email" name="correo" value="{{$empresa->correo}}" class="form-control" required>
                                            @error('correo')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="direccion">Dirección</label>
                                            <input id="pac-input" class="form-control" value="{{$empresa->direccion}}" name="direccion" type="text" placeholder="Buscar..." required>
                                            @error('direccion')
                                            <small style="color: red;">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="codigo_postal">Código Postal</label>
                                            <select name="codigo_postal" id="" class="form-control">
                                                @foreach($paises as $paise)
                                                    <option value="{{$paise->phone_code}}" {{$empresa->codigo_postal == $paise->phone_code ? 'selected':''}}>{{$paise->phone_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success btn-block">Actualizar datos</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                {{-- Card Footer --}}
                @hasSection('auth_footer')
                    <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                        @yield('auth_footer')
                    </div>
                @endif

            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        $('#select_pais').on('change',function () {
            var id_pais = $('#select_pais').val();
            //alert(pais);
            if(id_pais){
                $.ajax({
                    url:"{{url('/admin/configuracion/pais/')}}"+'/'+id_pais,
                    type: "GET",
                    success: function (data) {
                        $('#select_departamento_2').css('display','none');
                        $('#respuesta_pais').html(data);
                    }
                });
            }else{
                alert('Debe selecionar un país');
            }
        });
    </script>


    <script>
        $(document).on('change','#select_estado',function () {
            var id_estado = $(this).val();
            //alert(id_estado);
            if(id_estado){
                $.ajax({
                    url:"{{url('/admin/configuracion/estado/')}}"+'/'+id_estado,
                    type: "GET",
                    success: function (data) {
                        $('#select_ciudad_2').css('display','none');
                        $('#respuesta_estado').html(data);
                    }
                });
            }else{
                alert('Debe selecionar un país');
            }
        });
    </script>

@stop
