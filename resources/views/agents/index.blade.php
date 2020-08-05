@extends('layouts.app')

@section('content')
    <div class="container-planning-agents">
    @include('filters.planning_agent_filter', [
        'lpa' => true,
        'appeal_type' => true,
        'procedure' => true,
        'development_type' => true,
        'year' => true
    ])

    <div class="row custom-style-column-labels">
        <div class="col-md-12">
            <figure class="highcharts-figure">
                <div id="most_active_planning_agents_diagrams-container"></div>
            </figure>
        </div>

        <div class="col-md-12">
            <div class=""></div>

            <h1>Table Planning Agent</h1>
            <table id="data-table" class="table table-striped table-bordered data-table custom-style-table">
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
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <!-- Bootstrap 3.3.7 -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('.select2-filter').select2({ width: '200px' });

            let processing_parse = JSON.parse("{{ json_encode($processing_parse) }}");
            $('.btn-upload-file').prop('disabled', processing_parse);

            var filters = {};
            var dataTableCustom = $('.data-table').DataTable({
                processing: true,
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
                        dataTableCustom.clear();
                        dataTableCustom.rows.add(data.data);
                        dataTableCustom.draw();
                    });
            }

            const getTopTwentyAgentsData = () => {
                $.get('/api/agents/top-twenty', filters)
                    .done(function(data) {
                        if(data && data.data) {
                            columnLabelsChart.series[0].setData(data.data);
                        }
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
                getTopTwentyAgentsData();
            });
            getTopTwentyAgentsData();
            getAgentsData();


            var columnLabelsChart = Highcharts.chart('most_active_planning_agents_diagrams-container', {
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
                    // data: [],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#e2e5e8',
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

