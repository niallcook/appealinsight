@extends('layouts.app')

@section('content')
    @include('filters.planning_agent_filter', [
        'lpa' => true,
        'appeal_type' => true,
        'procedure' => true,
        'development_type' => true,
        'year' => true
    ])

    <div class="row justify-content-md-center mt-5">
        <div class="col-md-10">
            <figure class="highcharts-figure">
                <div id="most_active_planning_agents_diagrams-container"></div>
            </figure>
        </div>

        <div class="col-md-10">
            <div class="chart-column-with-rotated-labels"></div>

            <h1>Table Planning Agent</h1>
            <table class="table table-bordered data-table">
                <thead>
                <tr>
                    <th></th>
                    <th>Planning Agent</th>
                    <th width="100px">Appeal Count</th>
                    <th width="100px">Success Rate</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
{{--            @component('most_active_planning_agents_diagram.agent', ['processing_parse' => $processing_parse])--}}
{{--            @endcomponent--}}
        </div>
    </div>
{{--    @component('diagrams.most_active_planning_agents')--}}
{{--    @endcomponent--}}
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">

        var serializeToUrl = function(obj) {
            var str = [];
            for (var p in obj)
                if (obj.hasOwnProperty(p)) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
            return str.join("&");
        }

        $(function () {
            $('.select2-filter').select2();

            let processing_parse = JSON.parse("{{ json_encode($processing_parse) }}");
            $('.btn-upload-file').prop('disabled', processing_parse);

            var filters = {};
            var dataTable = $('.data-table').DataTable({
                processing: true,
                // serverSide: true,
                // ajax: "/api/agents?" + serializeToUrl(filters),
                data: [],

                columns: [
                    {
                        data: 'agent_id',
                        name: 'agent_id',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function (data, type, row ) {
                            return `<a href="/agent/${row.agent_id}">${data}</a>`;
                        }
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'success',
                        name: 'success',
                        render: function (data) {
                            return data + '%'
                        }
                    },
                    // {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            var getAgentsData = function() {
                $.get('/api/agents', filters)
                    .done(function(data) {
                        dataTable.clear();
                        dataTable.rows.add(data.data);
                        dataTable.draw();
                    });
            }

            $('.apply-filters').on('click', function() {
                filters = {};
                var lpa = $('.lpa-filter').val();
                if (parseInt(lpa, 10) !== -1) {
                    filters.lpa = lpa;
                }

                var type = $('.appeal-filter').val();
                if (parseInt(type, 10)  !== -1) {
                    filters.appeal_type = type;
                }

                var procedure = $('.procedure-filter').val();
                if (parseInt(procedure, 10)  !== -1) {
                    filters.procedure = procedure;
                }

                var development = $('.development-filter').val();
                if (parseInt(development, 10)  !== -1) {
                    filters.development_type = development;
                }
                getAgentsData();
            });
            getAgentsData();

            Highcharts.chart('most_active_planning_agents_diagrams-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '20 Most Active Planning Agents'
                },
                subtitle: {
                    // text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Population (millions)'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Population in 2017: <b>{point.y:.1f} millions</b>'
                },
                series: [{
                    name: 'Population',
                    data: [
                        ['Shanghai', 24.2],
                        ['Beijing', 20.8],
                        ['Karachi', 14.9],
                        ['Shenzhen', 13.7],
                        ['Guangzhou', 13.1],
                        ['Istanbul', 12.7],
                        ['Mumbai', 12.4],
                        ['Moscow', 12.2],
                        ['São Paulo', 12.0],
                        ['Delhi', 11.7],
                        ['Kinshasa', 11.5],
                        ['Tianjin', 11.2],
                        ['Lahore', 11.1],
                        ['Jakarta', 10.6],
                        ['Dongguan', 10.6],
                        ['Lagos', 10.6],
                        ['Bengaluru', 10.3],
                        ['Seoul', 9.8],
                        ['Foshan', 9.3],
                        ['Tokyo', 9.3]
                    ],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        format: '{point.y:.1f}', // one decimal
                        y: 10, // 10 pixels down from the top
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }]
            });

        });
    </script>
@endsection

