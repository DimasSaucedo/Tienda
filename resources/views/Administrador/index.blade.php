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
                <div class="card">
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
                    <div class="col-12 mb-3">
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

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex">
                                    <i class="fa-solid fa-user" style="font-size: 20px; margin-right: 10px"></i>
                                    <h5 class="card-title">Apartados</h5>
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
    </div>


    <script>
        // Datos de PHP convertidos a JavaScript
        var dinero_final = <?php echo json_encode($dinero_final); ?>;
        var guadalupano = <?php echo json_encode($guadalupano); ?>;
        var potreros = <?php echo json_encode($potreros); ?>;

        // Crear un mapa para almacenar los datos por semana
        var dataMap = {};

        // Función para llenar el mapa con datos
        function populateMap(dataArray, key) {
            dataArray.forEach(function(item) {
                dataMap[item.semana] = dataMap[item.semana] || {};
                dataMap[item.semana][key] = parseFloat(item.totalGanancia || item.dinero_final);
            });
        }

        // Llenar el mapa con datos de las tres series
        populateMap(dinero_final, 'dinero_final');
        populateMap(guadalupano, 'guadalupano');
        populateMap(potreros, 'potreros');

        // Extraer semanas y series de datos
        var semanas = Object.keys(dataMap);
        var data_dinero_final = semanas.map(function(semana) {
            return dataMap[semana].dinero_final || 0; // Valor por defecto 0 si no hay dato
        });
        var data_guadalupano_ganancia = semanas.map(function(semana) {
            return dataMap[semana].guadalupano || 0; // Valor por defecto 0 si no hay dato
        });
        var data_potreros_ganancia = semanas.map(function(semana) {
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
                    name: 'Ventas de potreros',
                    data: data_potreros_ganancia
                },
                {
                    name: 'Ventas del guadalupano',
                    data: data_guadalupano_ganancia
                },
                {
                    name: 'Ganancia total',
                    data: data_dinero_final
                }
            ]
        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Datos de PHP convertidos a JavaScript
            var dinero_final = <?php echo json_encode($dinero_final); ?>;
            var guadalupano = <?php echo json_encode($guadalupano); ?>;
            var potreros = <?php echo json_encode($potreros); ?>;

            // Crear un mapa para almacenar los datos por semana
            var dataMap = {};

            // Función para llenar el mapa con datos
            function populateMap(dataArray, key) {
                dataArray.forEach(function(item) {
                    dataMap[item.semana] = dataMap[item.semana] || {};
                    dataMap[item.semana][key] = parseFloat(item.totalGanancia || item.dinero_final);
                });
            }

            // Llenar el mapa con datos de las tres series
            populateMap(dinero_final, 'dinero_final');
            populateMap(guadalupano, 'guadalupano');
            populateMap(potreros, 'potreros');

            // Extraer semanas y series de datos
            var semanas = Object.keys(dataMap);
            var data_dinero_final = semanas.map(function(semana) {
                return dataMap[semana].dinero_final || 0; // Valor por defecto 0 si no hay dato
            });
            var data_guadalupano_ganancia = semanas.map(function(semana) {
                return dataMap[semana].guadalupano || 0; // Valor por defecto 0 si no hay dato
            });
            var data_potreros_ganancia = semanas.map(function(semana) {
                return dataMap[semana].potreros || 0; // Valor por defecto 0 si no hay dato
            });

            // Crear el gráfico Highcharts
            Highcharts.chart('container', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Ganancias del Año'
                },
                xAxis: {
                    categories: semanas,
                    accessibility: {
                        description: 'Semanas del año'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Dinero'
                    },
                    labels: {
                        format: '$ {value}'
                    }
                },
                tooltip: {
                    crosshairs: true,
                    shared: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#666666',
                            lineWidth: 1
                        }
                    }
                },
                series: [{
                    name: 'Ganancia Total',
                    marker: {
                        symbol: 'square'
                    },
                    data: data_dinero_final
                }, {
                    name: 'Ganancia Guadalupano',
                    marker: {
                        symbol: 'diamond'
                    },
                    data: data_guadalupano_ganancia
                }, {
                    name: 'Ganancia Potreros',
                    marker: {
                        symbol: 'diamond'
                    },
                    data: data_potreros_ganancia
                }]
            });
        });
    </script> --}}
@endsection
