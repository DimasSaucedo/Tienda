@extends('layouts.app')
@section('content')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-1 g-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ventas</h5>
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                            {{-- <p class="highcharts-description">
                                This chart shows how symbols and shapes can be used in charts.
                                Highcharts includes several common symbol shapes, such as squares,
                                circles and triangles, but it is also possible to add your own
                                custom symbols. In this chart, custom weather symbols are used on
                                data points to highlight that certain temperatures are warm while
                                others are cold.
                            </p> --}}
                        </figure>
                        {{-- <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                            additional
                            content. This content is a little bit longer.</p> --}}
                        <div class="text-center">
                            <a href="/ventas" class="btn btn-primary ">Acceder</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
    </script>
@endsection
