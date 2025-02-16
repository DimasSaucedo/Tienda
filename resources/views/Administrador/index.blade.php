@extends('layouts.app')
@section('content')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 310px;
            max-width: 800px;
            margin: 1em auto;
        }

        #container {
            height: 400px;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        h3 {
            font-family: 'Roboto', sans-serif;
            font-size: 10rem;
            font-weight: 700;
            color: #000000a4;
        }
    </style>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm-9">
                <div class="card" style="height: 100%">
                    <div class="card-body">
                        <div style="display: flex">
                            <i class="fa-solid fa-money-bill-trend-up" style="font-size: 20px; margin-right: 10px"></i>
                            <h5 class="card-title">Ventas</h5>
                        </div>
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                        </figure>
                        <div class="text-center">
                            <a href="/ventas" class="btn btn-primary">Acceder</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-12 mb-5">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex">
                                    <i class="fa-solid fa-book-skull" style="font-size: 20px; margin-right: 10px"></i>
                                    <h5 class="card-title">Apartados</h5>
                                </div>
                                <div class="text-center">
                                    <h3>{{ $numero_notas }}</h3>
                                    <div class="text-center">
                                        <a href="/apartados" class="btn btn-primary">Acceder</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex">
                                    <i class="fa-solid fa-user" style="font-size: 20px; margin-right: 10px"></i>
                                    <h5 class="card-title">Usuarios</h5>
                                </div>
                                <div class="text-center">
                                    <h3>{{ $numero_usuarios }}</h3>
                                    <div class="text-center">
                                        <a href="/usuarios" class="btn btn-primary">Acceder</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <figure class="highcharts-figure">
                            <div id="container-line"></div>
                            <p class="highcharts-description">
                                Evolición de precios
                            </p>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var fechas = @json($fechas);
        var preciosCompra = @json($precios_compra);
        var preciosVenta = @json($precios_venta);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Highcharts.chart('container-line', {
                title: {
                    text: 'Evolución de Precios de Venta y Compra',
                    align: 'left'
                },
    
                yAxis: {
                    title: {
                        text: 'Precio'
                    }
                },
    
                xAxis: {
                    categories: fechas, // Fechas desde Laravel
                    title: {
                        text: 'Fecha'
                    }
                },
    
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
    
                series: [{
                    name: 'Precio de Compra',
                    data: preciosCompra, // Datos de precio de compra
                    color: '#FF5733'
                }, {
                    name: 'Precio de Venta',
                    data: preciosVenta, // Datos de precio de venta
                    color: '#33FF57'
                }],
    
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });
        });
    </script>


    <script>
        // Datos de PHP convertidos a JavaScript
        var dinero_final = <?php echo json_encode($dinero_final); ?>;
        var guadalupano = <?php echo json_encode($guadalupano); ?>;
        var potreros = <?php echo json_encode($potreros); ?>;

        // Crear un mapa para almacenar los datos por semana
        var dataMap = {};

        // Función para llenar el mapa con datos
        function populateMap(dataArray, key) {
            dataArray.forEach(function (item) {
                const semana = (key === 'dinero_final') ? item.semana : item.semana_ajustada;
                if (!dataMap[semana]) {
                    dataMap[semana] = {
                        semana: semana
                    }; // Inicializar la semana solo una vez
                }
                dataMap[semana][key] = parseFloat(item.totalGanancia || item.dinero_final || 0);
            });
        }

        // Llenar el mapa con datos de las tres series
        populateMap(dinero_final, 'dinero_final');
        populateMap(guadalupano, 'guadalupano');
        populateMap(potreros, 'potreros');

        // Extraer semanas y series de datos
        var semanas = Object.keys(dataMap);
        var data_dinero_final = semanas.map(function (semana) {
            return dataMap[semana].dinero_final || 0; // Valor por defecto 0 si no hay dato
        });
        var data_guadalupano_ganancia = semanas.map(function (semana) {
            return dataMap[semana].guadalupano || 0; // Valor por defecto 0 si no hay dato
        });
        var data_potreros_ganancia = semanas.map(function (semana) {
            return dataMap[semana].potreros || 0; // Valor por defecto 0 si no hay dato
        });

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
                align: 'left'
            },
            xAxis: {
                categories: semanas,
                crosshair: true,
                accessibility: {
                    description: 'Semanas'
                },
                title: {
                    text: 'Semanas'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Dinero'
                }
            },
            tooltip: {
                valueSuffix: ' ($)'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Ganancia de potreros',
                data: data_potreros_ganancia
            },
            {
                name: 'Ganancia del guadalupano',
                data: data_guadalupano_ganancia
            },
            {
                name: 'Ganancia total',
                data: data_dinero_final
            }
            ]
        });
    </script>



@endsection