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

        /* Encabezado */
        .header {
            background: #f0f0f0;
        }

        /* Pie de página */
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

        /* Estilo del contenido */
        .content {
            margin: 20px 20px 50px 20px; /* Espacio para encabezado y pie */
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
            <td width="700px" style="text-align: center"><h1>SISTEMA DE VENTAS</h1></td>
            <td style="text-align: center">
                <img src="{{public_path('storage/'.$empresa->logo)}}" width="100px" alt="">
            </td>
        </tr>
    </table>
</div>

<div class="content">
    <h2>Reporte de productos</h2>
    <hr>
    <table border="0" class="table table-bordered" cellpadding="5">
        <tr>
            <td width="30px" style="background-color: #cccccc;text-align: center"><b>Nro</b></td>
            <td width="120px" style="background-color: #cccccc;text-align: center"><b>Código</b></td>
            <td width="180px" style="background-color: #cccccc;text-align: center"><b>Producto</b></td>
            <td width="50px" style="background-color: #cccccc;text-align: center"><b>Stock</b></td>
            <td width="90px" style="background-color: #cccccc;text-align: center"><b>Precio compra</b></td>
            <td width="90px" style="background-color: #cccccc;text-align: center"><b>Precio venta</b></td>
            <td width="150px" style="background-color: #cccccc;text-align: center"><b>Fecha de ingreso</b></td>
            <td width="150px" style="background-color: #cccccc;text-align: center"><b>Fecha y hora de registro</b></td>
        </tr>
        <tbody>
        @php
            $contador = 1;
        @endphp
        @foreach($productos as $producto)
            <tr>
                <td style="text-align: center">{{$contador++}}</td>
                <td>{{$producto->codigo}}</td>
                <td>
                    <b>{{$producto->nombre}}</b> <br>
                    <small>{{$producto->descripcion}}</small>
                </td>
                <td>{{$producto->stock}}</td>
                <td>{{$producto->precio_compra}}</td>
                <td>{{$producto->precio_venta}}</td>
                <td>{{$producto->fecha_ingreso}}</td>
                <td>{{$producto->created_at}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

<div class="footer">
    <small class="page-number"></small>
</div>


</body>
</html>
