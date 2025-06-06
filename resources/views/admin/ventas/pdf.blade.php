<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<table border="0" style="font-size: 8pt">
    <tr>
        <td style="text-align: center"><img src="{{public_path('storage/'.$empresa->logo)}}" width="100px" alt=""></td>
        <td width="500px"></td>
        <td style="text-align: center">
            <b>NIT: </b>{{$empresa->nit}}<br>
            <b>Nro Factura: </b>{{$venta->id}} <br>
        </td>
    </tr>
    <tr>
        <td style="text-align: center">
            {{$empresa->nombre_empresa}} <br>
            {{$empresa->tipo_empresa}} <br>
            {{$empresa->correo}} <br>
            Tel: {{$empresa->telefono}} <br>
        </td>
        <td width="500px" style="text-align: center"><h1>FACTURA</h1></td>
        <td style="text-align: center"><h4>ORIGINAL</h4></td>
    </tr>
</table>

<br>

<?php
$fecha_db = $venta->fecha;

// Convertir la fecha al formato deseado
$fecha_formateada = date("d", strtotime($fecha_db)) . " de " .
    date("F", strtotime($fecha_db)) . " de " .
    date("Y", strtotime($fecha_db));

$meses = [
    'January' => 'enero',
    'February' => 'febrero',
    'March' => 'marzo',
    'April' => 'abril',
    'May' => 'mayo',
    'June' => 'junio',
    'July' => 'julio',
    'August' => 'agosto',
    'September' => 'septiembre',
    'October' => 'octubre',
    'November' => 'noviembre',
    'December' => 'diciembre'
];

$fecha_formateada = str_replace(array_keys($meses), array_values($meses), $fecha_formateada);


?>

<div style="border: 1px solid #000000">
    <table border="0" cellpadding="6">
        <tr>
            <td width="400px"><b>Fecha: </b>{{$fecha_formateada}}</td>
            <td width="100px"></td>
            <td><b>Nit/CI: </b>{{$venta->cliente->nit_codigo}}</td>
        </tr>
        <tr>
            <td><b>Señor(es): </b>{{$venta->cliente->nombre_cliente}}</td>
        </tr>
    </table>
</div>

<br>

<table border="0" class="table table-bordered">
    <tr>
        <td width="30px" style="background-color: #cccccc;text-align: center"><b>Nro</b></td>
        <td width="150px" style="background-color: #cccccc;text-align: center"><b>Productos</b></td>
        <td width="210px" style="background-color: #cccccc;text-align: center"><b>Descripción</b></td>
        <td width="90px" style="background-color: #cccccc;text-align: center"><b>Cantidad</b></td>
        <td width="110px" style="background-color: #cccccc;text-align: center"><b>Precio Unitario</b></td>
        <td width="90px" style="background-color: #cccccc;text-align: center"><b>SubTotal</b></td>
    </tr>
    <tbody>
    @php
        $contador = 1;
        $subtotal = 0;
        $suma_cantidad = 0;
        $suma_precio_unitario = 0;
        $suma_subtotal = 0;
    @endphp
    @foreach($venta->detallesVenta as $detalle)
        @php
            $suma_cantidad += $detalle->cantidad;
            $subtotal = $detalle->cantidad * $detalle->producto->precio_venta;
            $suma_precio_unitario += $detalle->producto->precio_venta;
            $suma_subtotal += $subtotal;
        @endphp
        <tr>
            <td style="text-align: center">{{$contador++}}</td>
            <td>{{$detalle->producto->nombre}}</td>
            <td>{{$detalle->producto->descripcion}}</td>
            <td style="text-align: center">{{$detalle->cantidad}}</td>
            <td style="text-align: center">{{$moneda->symbol." ".$detalle->producto->precio_venta}}</td>
            <td style="text-align: center">{{$moneda->symbol." ".$subtotal}}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3" style="background-color: #cccccc;text-align: center"><b>Total</b></td>
        <td style="background-color: #cccccc;text-align: center"><b>{{$suma_cantidad}}</b></td>
        <td style="background-color: #cccccc;text-align: center"><b>{{$moneda->symbol." ".$suma_precio_unitario}}</b></td>
        <td style="background-color: #cccccc;text-align: center"><b>{{$moneda->symbol." ".$suma_subtotal}}</b></td>
    </tr>
    </tbody>
</table>

<p>
    <b>Monto a cancelar: </b>{{$venta->precio_total}} <br><br>
    <b>Son: </b>{{$literal}}
</p>
<p style="text-align: center">
    ----------------------------------------------------------------------------------------------------------------------------------------------
    <br><B>GRACIAS POR SU PROFERENCIA</B>
</p>

</body>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt; /* Ajusta el tamaño */
            color: #333; /* Cambia el color de la fuente */
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
    <title>Sistema de ventas</title>
</head>
</html>
