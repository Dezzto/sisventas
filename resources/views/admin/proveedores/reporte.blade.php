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
    <h2>Reporte de proveedores</h2>
    <hr>
    <table border="0" class="table table-bordered" cellpadding="5">
        <tr>
            <td width="30px" style="background-color: #cccccc;text-align: center"><b>Nro</b></td>
            <td width="80px" style="background-color: #cccccc;text-align: center"><b>Empresa</b></td>
            <td width="180px" style="background-color: #cccccc;text-align: center"><b>Dirección</b></td>
            <td width="80px" style="background-color: #cccccc;text-align: center"><b>Teléfono</b></td>
            <td width="100px" style="background-color: #cccccc;text-align: center"><b>Email</b></td>
            <td width="90px" style="background-color: #cccccc;text-align: center"><b>Nombre</b></td>
            <td width="80px" style="background-color: #cccccc;text-align: center"><b>Celular</b></td>
            <td width="130px" style="background-color: #cccccc;text-align: center"><b>Fecha y hora de registro</b></td>
        </tr>
        <tbody>
        @php
            $contador = 1;
        @endphp
        @foreach($proveedores as $proveedore)
            <tr>
                <td style="text-align: center">{{$contador++}}</td>
                <td>{{$proveedore->empresa}}</td>
                <td>{{$proveedore->direccion}}</td>
                <td>{{$proveedore->telefono}}</td>
                <td>{{$proveedore->email}}</td>
                <td>{{$proveedore->nombre}}</td>
                <td>{{$proveedore->celular}}</td>
                <td>{{$proveedore->created_at}}</td>
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
