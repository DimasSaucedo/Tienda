<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            /* Utiliza la fuente Georgia para un estilo formal */
        }

        /* Estilo básico de la tabla */
        table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        /* Filas alternadas con color de fondo */
        table tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        /* Encabezado de la tabla */
        thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            text-align: left;
            padding: 0.75rem;
            background-color: #e8bff9;
            font-weight: bold;
        }

        /* Celdas de la tabla */
        td,
        th {
            padding: 0.75rem;
            border-top: 1px solid #9d9d9d;
        }

        /* Centrar el contenido en las celdas */
        .text-center {
            text-align: center;
        }

        /* Borde alrededor de la tabla */
        .table {
            border: 1px solid #9d9d9d;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        /* Estilo para filas hover */
        tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>

</head>

<body>
    <h2>Ventas de la semana: {{$fecha_inicio->format('Y-m-d');}} - {{$fecha_fin->format('Y-m-d');}}</h2>
    <div style="float: right">
        <p><strong>Total: </strong>{{$dinero_final->dinero_final}}</p>
    </div>
    <br>
    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">Cantidad</th>
                <th>Producto</th>
                <th>Forma de pago</th>
                <th class="text-center">Precio Compra</th>
                <th class="text-center">Precio Venta</th>
                <th class="text-center">Ganancia</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $row)
            <tr>
                <td class="text-center">{{$row->cantidad}}</td>
                <td>{{$row->descripcion}}</td>
                <td>{{metodo_de_pago($row->forma_pago)}}</td>
                <td class="text-center">{{formatearNumero($row->precio_compra)}}</td>
                <td class="text-center">{{formatearNumero($row->precio_venta)}}</td>
                <td class="text-center"></td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center">{{formatearNumero($dinero_final->totalPrecioCompra)}}</td>
                <td class="text-center">{{formatearNumero($dinero_final->totalPrecioVenta)}}</td>
                <td class="text-center">{{formatearNumero($dinero_final->total_ganancia)}}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <h2>Gastos</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Forma de pago</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Dinero</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gastos as $row)
            <tr>
                <td>{{$row->descripcion}}</td>
                <td>{{metodo_de_pago($row->forma_pago)}}</td>
                <td class="text-center">{{$row->fecha}}</td>
                <td class="text-center">{{formatearNumero($row->dinero)}}</td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td class="text-center"></td>
                <td class="text-center">{{$dinero_final->total_gastos}}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>