<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .header {
            background: #f0f0f0;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            background: #f0f0f0;
            text-align: center;
            line-height: 30px;
            font-size: 12px;
            border-top: 1px solid #ddd;
        }

        .content {
            margin: 20px 20px 50px 20px;
        }

        .page-number:before {
            content: "Página " counter(page);
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table-bordered {
            border: 1px solid #000000;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000000;
        }

        .table-bordered thead th {
            border-bottom-width: 2px;
        }
    </style>
</head>
<body>

<div class="header">
    <table border="0" style="font-size: 8pt">
        <tr>
            <td style="text-align: center">
                {{$empresa->nombre_empresa}} <br>
                {{$empresa->tipo_empresa}} <br>
                {{$empresa->correo}} <br>
                Tel: {{$empresa->telefono}} <br>
            </td>
            <td width="500px" style="text-align: center"><h1>SISTEMA DE VENTAS</h1></td>
            <td style="text-align: center">
                <img src="{{public_path('storage/'.$empresa->logo)}}" width="100px" alt="">
            </td>
        </tr>
    </table>
</div>

<div class="content">
    <h2>Reporte de ventas</h2>
    <hr>
    <table border="0" class="table table-bordered" cellpadding="5">
        <thead>
        <tr>
            <th style="background-color: #cccccc;text-align: center"><b>Nro</b></th>
            <th style="background-color: #cccccc;text-align: center"><b>Fecha de venta</b></th>
            <th style="background-color: #cccccc;text-align: center"><b>Precio total</b></th>
            <th style="background-color: #cccccc;text-align: center"><b>Cliente</b></th>
            <th style="background-color: #cccccc;text-align: center"><b>Nit/Código</b></th>
            <th style="background-color: #cccccc;text-align: center"><b>Fecha y hora de registro</b></th>
        </tr>
        </thead>
        <tbody>
        @php
            $contador = 1;
            $suma_total = 0;
        @endphp
        @foreach($ventas as $venta)
            @php
                $suma_total += $venta->precio_total;
            @endphp
            <tr>
                <td style="text-align: center">{{$contador++}}</td>
                <td>{{$venta->fecha}}</td>
                <td>{{$venta->precio_total}}</td>
                <td>{{ $venta->cliente->nombre_cliente ?? '---' }}</td>
                <td>{{ $venta->cliente->nit_codigo ?? '---' }}</td>
                <td>{{$venta->created_at}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p><b>Total en ventas: </b>{{$suma_total}}</p>
</div>

<div class="footer">
    <small class="page-number"></small>
</div>

</body>
</html>
