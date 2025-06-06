@extends('adminlte::master')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
    <div class="container">

        <br>
        <center>
            <img src="{{asset('/images/logo.jpg')}}" width="250px" alt="">
        </center>
        <br>

        <div class="row">
            <div class="col-md-12">
                {{-- Card Box --}}
                <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}"
                     style="box-shadow: 5px 5px 5px 5px #cccccc" >

                    <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                        <h3 class="card-title float-none text-center">
                            <b>Registro de una nueva empresa</b>
                        </h3>
                    </div>


                    {{-- Card Body --}}
                    <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                        <form action="{{url('crear-empresa/create')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="logo">Logo</label>
                                        <input type="file" id="file" name="logo" accept=".jpg, .jpeg, .png" class="form-control" required>
                                        @error('logo')
                                        <small style="color: red;">{{$message}}</small>
                                        @enderror
                                        <br>
                                        <center><output id="list"></output></center>
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
                                                        <option value="{{$paise->id}}">{{$paise->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="departamento">Estado/Provincia/Región</label>
                                                <div id="respuesta_pais">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="ciudad">Ciudad</label>
                                                <div id="respuesta_estado">

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="nombre_empresa">Nombre de la Empresa</label>
                                                <input type="text" value="{{old('nombre_empresa')}}" name="nombre_empresa" class="form-control" required>
                                                @error('nombre_empresa')
                                                <small style="color: red;">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tipo_empresa">Tipo de la Empresa</label>
                                                <input type="text" value="{{old('tipo_empresa')}}" name="tipo_empresa" class="form-control" required>
                                                @error('tipo_empresa')
                                                <small style="color: red;">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="nit">NIT</label>
                                                <input type="text" name="nit" value="{{old('nit')}}" class="form-control" required>
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
                                                        <option value="{{$moneda->id}}">{{$moneda->symbol}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="nombre_impuesto">Nombre del impuesto</label>
                                                <input type="text" name="nombre_impuesto" value="{{old('nombre_impuesto')}}" class="form-control" required>
                                                @error('nombre_impuesto')
                                                <small style="color: red;">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="cantidad_impuesto">Cantidad</label>
                                                <input type="number" value="{{old('cantidad_impuesto')}}" name="cantidad_impuesto" class="form-control" required>
                                                @error('cantidad_impuesto')
                                                <small style="color: red;">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="telefono">Teléfonos de la Empresa</label>
                                                <input type="text" name="telefono" value="{{old('telefono')}}" class="form-control" required>
                                                @error('telefono')
                                                <small style="color: red;">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="correo">Correo de la Empresa</label>
                                                <input type="email" name="correo" value="{{old('correo')}}" class="form-control" required>
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
                                                <input id="pac-input" class="form-control" value="{{old('direccion')}}" name="direccion" type="text" placeholder="Buscar..." required>
                                                @error('direccion')
                                                <small style="color: red;">{{$message}}</small>
                                                @enderror
                                                <br>
                                                <div id="map" style="width: 100%;height: 400px"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="codigo_postal">Código Postal</label>
                                                <select name="codigo_postal" id="" class="form-control">
                                                    @foreach($paises as $paise)
                                                        <option value="{{$paise->phone_code}}">{{$paise->phone_code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-lg btn-primary btn-block">Crear empresa</button>
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



    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('MAP_KEY')}}&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script>
        // This example adds a search box to a map, using the Google Place Autocomplete
        // feature. People can enter geographical searches. The search box will return a
        // pick list containing a mix of places and predicted search terms.

        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

        function initAutocomplete() {
            var map = new google.maps.Map(document.getElementById('map'), {
                // Coordenadas de Monterrey, N.L., México
                center: {lat: 25.685088, lng:-100.327482}, //{lat: -33.8688, lng: 151.2195},
                zoom: 13,
                mapTypeId: 'roadmap'
            });

            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input); // determina la posicion

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                /*
                 * Para fines de minimizar las adecuaciones debido a que es este una demostración de adaptación mínima de código, se reemplaza forEach por some.
                 */
                // places.forEach(function(place) {
                places.some(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                    // some interrumpe su ejecución en cuanto devuelve un valor verdadero (true)
                    return true;
                });
                map.fitBounds(bounds);
            });
        }
    </script>

    <script>
        $('#select_pais').on('change',function () {
            var id_pais = $('#select_pais').val();
            //alert(pais);
            if(id_pais){
                $.ajax({
                    url:"{{url('/crear-empresa/pais/')}}"+'/'+id_pais,
                    type: "GET",
                    success: function (data) {
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
                    url:"{{url('/crear-empresa/estado/')}}"+'/'+id_estado,
                    type: "GET",
                    success: function (data) {
                        $('#respuesta_estado').html(data);
                    }
                });
            }else{
                alert('Debe selecionar un país');
            }
        });
    </script>

@stop
