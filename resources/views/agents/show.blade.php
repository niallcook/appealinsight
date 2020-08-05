@extends('layouts.app')

@section('content')
    @include('filters.planning_agent_filter', [
        'lpa' => false,
        'appeal_type' => false,
        'procedure' => false,
        'development_type' => false,
        'year' => true
       ])

    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <figure class="highcharts-figure">
                <div id="development-type-chart-container"></div>
            </figure>
            <div class="col-md-6">
                <figure class="highcharts-figure">
                    <div id="basic-column-container"></div>
                </figure>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
{{--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>--}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

{{--<script src="https://code.highcharts.com/highcharts.js"></script>--}}
{{--<script src="https://code.highcharts.com/modules/exporting.js"></script>--}}
{{--<script src="https://code.highcharts.com/modules/export-data.js"></script>--}}
{{--<script src="https://code.highcharts.com/modules/accessibility.js"></script>--}}

    <script type="text/javascript">
        $(function () {
            Highcharts.chart('basic-column-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Monthly Average Rainfall'
                },
                subtitle: {
                    text: 'Source: WorldClimate.com'
                },
                xAxis: {
                    categories: [
                        'Jan',
                        'Feb',
                        'Mar',
                        'Apr',
                        'May',
                        'Jun',
                        'Jul',
                        'Aug',
                        'Sep',
                        'Oct',
                        'Nov',
                        'Dec'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Rainfall (mm)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Tokyo',
                    data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

                }, {
                    name: 'New York',
                    data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

                }, {
                    name: 'London',
                    data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

                }, {
                    name: 'Berlin',
                    data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

                }]
            });




            // Build the chart
            Highcharts.chart('development-type-chart', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Browser market shares in January, 2018'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: [{
                        name: 'Change of use',
                        y: 3,
                        // sliced: true,
                        // selected: true
                    }, {
                        name: 'Minor Dwellings',
                        y: 5
                    }, {
                        name: 'Householder developments',
                        y: 5
                    },
                    // {
                    //     name: 'Edge',
                    //     y: 4.67
                    // }, {
                    //     name: 'Safari',
                    //     y: 4.18
                    // }, {
                    //     name: 'Other',
                    //     y: 7.05
                    // }
                    ]
                }]
            });
        });

    </script>
@endsection
